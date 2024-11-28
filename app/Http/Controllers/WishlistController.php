<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\admin\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm yêu thích của người dùng.
     */
    public function index()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())
            ->with('product') // Lấy thông tin sản phẩm
            ->get();

        return view('user.wishlist.index', compact('wishlists'));
    }

    /**
     * Thêm sản phẩm vào danh sách yêu thích.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = Wishlist::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
            ]
        );
        if ($wishlist->wasRecentlyCreated) {
            return back()->with('success', 'Sản phẩm đã được thêm vào danh sách yêu thích!');
        }
        return back()->with('info', 'Sản phẩm đã có trong danh sách yêu thích!');
        // return redirect()->route('wishlist.index')->with('success', 'Sản phẩm đã được thêm vào danh sách!');
    }

    /**
     * Xóa sản phẩm khỏi danh sách yêu thích.
     */
    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $wishlist->delete();

        return back()->with('success', 'Sản phẩm đã được xóa khỏi danh sách yêu thích!');
    }
}

