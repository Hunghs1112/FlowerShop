<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function index()
    {
        $cartItems = $this->cartService->getCartItems();
        $total = $this->cartService->getTotal();
        $bannerKey = 'cart';
        return view('cart.index', compact('cartItems', 'total', 'bannerKey'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        try {
            $this->cartService->addItem(
                $validated['product_id'], 
                $validated['quantity'],
                $validated['variant_id'] ?? null
            );
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 422);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm vào giỏ hàng',
                'cart_count' => $this->cartService->getItemsCount(),
            ]);
        }

        if ($request->boolean('buy_now')) {
            if (!auth()->check()) {
                return redirect()->guest(route('checkout.index'));
            }

            return redirect()->route('checkout.index');
        }

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        try {
            $this->cartService->updateQuantity($id, $validated['quantity']);
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'total' => $this->cartService->getTotal(),
                'cart_count' => $this->cartService->getItemsCount(),
            ]);
        }

        return redirect()->back()->with('success', 'Đã cập nhật giỏ hàng');
    }

    public function remove(int $id)
    {
        $this->cartService->removeItem($id);

        return redirect()->back()->with('success', 'Đã xóa khỏi giỏ hàng');
    }

    public function destroy(int $id)
    {
        return $this->remove($id);
    }

    public function clear()
    {
        $this->cartService->clearCart();

        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng');
    }
}
