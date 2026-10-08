<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlowerOrigin;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PassportController extends Controller
{
    public function index(): JsonResponse
    {
        $user = request()->user();
        if (!$user) {
            return response()->json(['loggedIn' => false, 'stamps' => []]);
        }

        // Build origin string → country_code lookup from FlowerOrigin records
        $origins = FlowerOrigin::whereNotNull('country_code')
            ->where('country_code', '!=', 'hn')
            ->get();

        // Map: origin strings (lowercased) → country codes
        $originToCode = [];
        foreach ($origins as $o) {
            // Match on country name, flower name, and slug variants
            $keys = array_filter([
                Str::lower($o->country),
                Str::lower($o->region),
                Str::lower($o->flower),
                Str::slug($o->country),
                Str::slug($o->region),
                Str::slug($o->flower),
                $o->slug,
                $o->country_code === 'cn' ? 'kunming' : null,
                $o->country_code === 'cn' ? Str::slug('Côn Minh') : null,
            ]);
            foreach ($keys as $key) {
                $originToCode[$key] = $o->country_code;
            }
        }

        $stamps = [];
        $seen = [];

        $completedOrders = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->with('items.product')
            ->get();

        foreach ($completedOrders as $order) {
            foreach ($order->items as $item) {
                $originStr = $item->product?->origin;
                if (!$originStr) continue;

                $originLower = Str::lower($originStr);
                $originSlug = Str::slug($originStr);

                $code = $originToCode[$originLower]
                    ?? $originToCode[$originSlug]
                    ?? null;

                // Fallback: scan for partial matches
                if (!$code) {
                    foreach ($originToCode as $key => $c) {
                        if (str_contains($originLower, $key) || str_contains($originSlug, $key)) {
                            $code = $c;
                            break;
                        }
                    }
                }

                if (!$code || isset($seen[$code])) continue;
                $seen[$code] = true;
                $stamps[] = [
                    'country' => $code,
                    'date' => $order->created_at->format('Y-m-d'),
                    'order' => '#LNT' . $order->id,
                ];
            }
        }

        return response()->json([
            'loggedIn' => true,
            'name' => $user->name,
            'stamps' => $stamps,
        ]);
    }
}
