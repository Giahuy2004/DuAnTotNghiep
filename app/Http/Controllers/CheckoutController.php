<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\admin\Product;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function showConfirmCheckout(Request $request)
    {
        $cart = session('cart');

        // Kiểm tra giỏ hàng
        if (!$cart || count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Tính tổng giá trị đơn hàng
        $totalPrice = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        // Truyền dữ liệu giỏ hàng và tổng giá trị sang view
        return view('confirm_checkout', compact('cart', 'totalPrice'));
    }
    
    public function success()
    {
        return view('user.success'); // Đổi tên view nếu cần
    }
}
