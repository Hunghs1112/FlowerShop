<?php

namespace App\Http\Controllers;

use App\Models\MysteryBoxRequest;
use App\Services\MysteryBoxContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MysteryBoxController extends Controller
{
    public function __construct(private MysteryBoxContentService $contentService)
    {
    }

    /**
     * Display mystery box form.
     */
    public function index()
    {
        $user = Auth::user();
        $bannerKey = 'mystery-box';
        $mysteryContent = $this->contentService->get();

        return view('mystery-box.index', compact('user', 'bannerKey', 'mysteryContent'));
    }

    /**
     * Store mystery box request.
     */
    public function store(Request $request)
    {
        $content = $this->contentService->get();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^[0-9\+\-\s]+$/',
            'email' => 'nullable|email|max:255',
            'style' => ['required', Rule::in($content['styles'])],
            'colors' => 'required|array|min:1',
            'colors.*' => [Rule::in($content['colors'])],
            'preferences' => 'required|array|min:1',
            'preferences.*' => [Rule::in($content['preferences'])],
            'budget_range' => ['required', Rule::in(array_column($content['budgets'], 'value'))],
            'surprise_level' => ['required', Rule::in($content['surprise_levels'])],
            'note' => 'nullable|string|max:1000',
        ]);

        $mysteryBoxRequest = MysteryBoxRequest::create([
            'request_id' => MysteryBoxRequest::generateRequestId(),
            'user_id' => Auth::id(),
            'name' => strip_tags($validated['name']),
            'phone' => strip_tags($validated['phone']),
            'email' => isset($validated['email']) ? filter_var($validated['email'], FILTER_SANITIZE_EMAIL) : null,
            'style' => $validated['style'],
            'colors' => $validated['colors'],
            'preferences' => $validated['preferences'],
            'budget_range' => $validated['budget_range'],
            'surprise_level' => $validated['surprise_level'],
            'note' => isset($validated['note']) ? strip_tags($validated['note']) : null,
            'status' => 'new',
        ]);

        return redirect()->route('mystery-box.success', $mysteryBoxRequest);
    }

    /**
     * Display success page.
     */
    public function success(MysteryBoxRequest $request)
    {
        $bannerKey = 'mystery-box';
        $mysteryBoxRequest = $request;
        $mysteryContent = $this->contentService->get();

        return view('mystery-box.success', compact('mysteryBoxRequest', 'bannerKey', 'mysteryContent'));
    }
}
