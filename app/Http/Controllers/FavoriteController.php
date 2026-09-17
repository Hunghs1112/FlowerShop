<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display user's favorite products
     */
    public function index()
    {
        $favorites = Favorite::with('product.productImages', 'product.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Toggle favorite status for a product
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;

        // Check if already favorited
        $favorite = Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Đã xóa khỏi danh sách yêu thích'
            ]);
        } else {
            // Add to favorites
            Favorite::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Đã thêm vào danh sách yêu thích'
            ]);
        }
    }

    /**
     * Remove from favorites
     */
    public function destroy($id)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $favorite->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa khỏi danh sách yêu thích'
        ]);
    }
}
