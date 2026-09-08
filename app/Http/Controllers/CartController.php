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

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->addItem($validated['product_id'], $validated['quantity']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm vào giỏ hàng',
                'cart_count' => $this->cartService->getItemsCount(),
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $this->cartService->updateQuantity($id, $validated['quantity']);

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
