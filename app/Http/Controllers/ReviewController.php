<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\admin\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        $reviews = $product->reviews()->with('user')->get(); // Lấy tất cả đánh giá của sản phẩm

        return view('products.show', compact('product', 'reviews'));
    }

    // Thêm mới đánh giá
    public function store(Request $request, $productId)
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để đánh giá sản phẩm.');
        }
        // Kiểm tra xem người dùng đã mua sản phẩm này chưa
        $user = Auth::user();
        $product = Product::findOrFail($productId);
        
        // Kiểm tra đơn hàng đã thanh toán và chứa sản phẩm này
        $hasPurchased = Order::where('user_id', $user->id)
                            ->whereHas('products', function ($query) use ($product) {
                                $query->where('product_id', $product->id);
                            })
                            ->where('status', 'completed') // Đảm bảo đơn hàng đã hoàn thành
                            ->exists();

        if (!$hasPurchased) {
            return redirect()->route('products.show', $productId)
                             ->with('error', 'Bạn cần mua sản phẩm này trước khi có thể đánh giá.');
        }

        // Xác thực dữ liệu
        $request->validate([
            'rating' => 'required|integer|min:1|max:5', // Điểm đánh giá từ 1 đến 5
            'comment' => 'nullable|string|max:255',
        ]);

        // Tạo mới đánh giá
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return back()->with('success', 'Đánh giá của bạn đã được gửi!');
    }

    // Xóa đánh giá
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Kiểm tra nếu người dùng có quyền xóa
        if ($review->user_id != Auth::id()) {
            return back()->with('error', 'Bạn không có quyền xóa đánh giá này.');
        }

        $review->delete();

        return back()->with('success', 'Đánh giá đã được xóa.');
    }
}
