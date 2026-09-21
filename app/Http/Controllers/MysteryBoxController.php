<?php

namespace App\Http\Controllers;

use App\Models\MysteryBoxRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MysteryBoxController extends Controller
{
    /**
     * Display mystery box form
     */
    public function index()
    {
        $user = Auth::user();
        $bannerKey = 'mystery-box';
        
        return view('mystery-box.index', compact('user', 'bannerKey'));
    }

    /**
     * Store mystery box request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^[0-9\+\-\s]+$/',
            'email' => 'nullable|email|max:255',
            'style' => 'required|in:Thanh lịch,Lãng mạn,Tự nhiên,Tối giản,Sang trọng',
            'colors' => 'required|array|min:1',
            'colors.*' => 'in:Trắng,Kem,Hồng,Xanh,Đỏ,Pastel,Không giới hạn',
            'preferences' => 'required|array|min:1',
            'preferences.*' => 'in:Nhiều hoa,Ít hoa,Nhiều lá,Nhẹ nhàng,Nổi bật,Tự nhiên',
            'budget_range' => 'required|in:500k-1M,1M-2M,2M-5M,5M+',
            'surprise_level' => 'required|in:Bất ngờ hoàn toàn,Bất ngờ một phần,Muốn giữ một vài yêu cầu',
            'note' => 'nullable|string|max:1000',
        ]);

        // Generate request ID
        $requestId = MysteryBoxRequest::generateRequestId();

        // Create mystery box request
        $mysteryBoxRequest = MysteryBoxRequest::create([
            'request_id' => $requestId,
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
     * Display success page
     */
    public function success(MysteryBoxRequest $request)
    {
        $bannerKey = 'mystery-box';
        $mysteryBoxRequest = $request;
        
        return view('mystery-box.success', compact('mysteryBoxRequest', 'bannerKey'));
    }
}
