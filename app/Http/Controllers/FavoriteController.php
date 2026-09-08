<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()
            ->favorites()
            ->with(['product.productImages', 'product.category'])
            ->latest()
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        // Check if already favorited
        $existing = Favorite::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existing) {
            // Remove from favorites
            $existing->delete();
            $message = 'Đã xóa khỏi yêu thích';
        } else {
            // Add to favorites
            Favorite::create([
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'],
            ]);
            $message = 'Đã thêm vào yêu thích';
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroy($id)
    {
        // Check if $id is a product_id or favorite_id
        $favorite = Favorite::where('user_id', auth()->id())
            ->where(function($query) use ($id) {
                $query->where('id', $id)
                      ->orWhere('product_id', $id);
            })
            ->first();

        if ($favorite) {
            $favorite->delete();
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa khỏi yêu thích',
            ]);
        }

        return redirect()->back()->with('success', 'Đã xóa khỏi yêu thích');
    }
}
