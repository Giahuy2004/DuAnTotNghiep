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
    public function store(Request $request, $productId)
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm vào yêu thích.');
        }

        // Kiểm tra xem sản phẩm có tồn tại không
        $product = Product::findOrFail($productId);

        // Kiểm tra xem sản phẩm đã có trong danh sách yêu thích của người dùng chưa
        $existingWishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingWishlist) {
            // Nếu sản phẩm đã có trong danh sách yêu thích, trả về thông báo
            return redirect()->route('wishlist.index')->with('error', 'Sản phẩm này đã có trong danh sách yêu thích!');
        }

        // Nếu chưa có, thêm sản phẩm vào danh sách yêu thích
        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        // Trả về thông báo thành công
        return redirect()->route('wishlist.index')->with('success', 'Sản phẩm đã được thêm vào danh sách yêu thích!');
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
