<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerController extends Controller
{
    public function index(): View
    {
        $page = Page::where('slug', 'tuyen-dung')->active()->firstOrFail();
        $config = json_decode($page->display_content, true, flags: JSON_THROW_ON_ERROR);

        return view('pages.career', compact('page', 'config'));
    }

    public function store(Request $request): JsonResponse
    {
        $page = Page::where('slug', 'tuyen-dung')->active()->firstOrFail();
        $config = json_decode($page->content, true, flags: JSON_THROW_ON_ERROR);
        $jobs = collect($config['jobs'] ?? []);

        $validated = $request->validate([
            'position' => 'required|integer|min:0',
            'name' => 'required|string|max:255',
            'year' => 'nullable|digits:4|integer|min:1940|max:'.now()->year,
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+().\s-]{9,20}$/'],
            'email' => 'required|email|max:255',
            'cv' => 'nullable|url|max:1000',
            'note' => 'nullable|string|max:3000',
        ]);

        $job = $jobs->get($validated['position']);
        abort_unless($job && ($job['status'] ?? null) === 'open', 422, __('customer.messages.career_closed'));

        Inquiry::create([
            'user_id' => auth()->id(),
            'type' => 'career_application',
            'source_slug' => 'tuyen-dung',
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'message' => $validated['note'] ?? '',
            'order_data' => [
                'position' => $job['title'],
                'year' => $validated['year'] ?? null,
                'cv' => $validated['cv'] ?? null,
            ],
            'status' => 'new',
        ]);

        return response()->json(['message' => __('customer.messages.career_received')], 201);
    }
}
