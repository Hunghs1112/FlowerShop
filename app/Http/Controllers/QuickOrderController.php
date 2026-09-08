<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Http\Request;

class QuickOrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'zalo_id' => 'nullable|string|max:50',
            'message' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($request->product_id);

        $inquiry = Inquiry::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'zalo_id' => $request->zalo_id,
            'product_ids' => json_encode([$product->id]),
            'message' => $request->message,
            'status' => 'new',
        ]);

        return redirect()->route('checkout.success', ['inquiry' => $inquiry->id])
            ->with('success', 'Đơn hàng nhanh của bạn đã được gửi thành công!');
    }
}
