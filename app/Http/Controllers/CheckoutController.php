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
    // public function processCheckout(Request $request)
    // {
    //     // Validate customer input
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'address' => 'required|string|max:255',
    //         'phone' => 'required|string|max:15',
    //         'payment_method' => 'required|string|in:cod,qr',
    //     ]);

    //     // Retrieve customer information and cart
    //     $customerName = $request->input('name');
    //     $customerAddress = $request->input('address');
    //     $customerPhone = $request->input('phone');
    //     $paymentMethod = $request->input('payment_method');
    //     $cart = session('cart');

    //     // Calculate total price of the order
    //     $totalPrice = array_sum(array_map(function ($item) {
    //         return $item['price'] * $item['quantity'];
    //     }, $cart));

    //     // Create the order
    //     $order = new Order();
    //     $order->user_id = auth()->user()->id; // Assuming the user is logged in
    //     $order->name = $customerName;
    //     $order->address = $customerAddress;
    //     $order->phone = $customerPhone;
    //     $order->total_price = $totalPrice;
    //     $order->payment_method = $paymentMethod;
    //     $order->status = 'pending'; // Change status as needed
    //     $order->save();

    //     // Save order details (cart items)
    //     foreach ($cart as $item) {
    //         $orderDetail = new OrderDetail();
    //         $orderDetail->order_id = $order->id;
    //         $orderDetail->product_id = $item['product_id'];
    //         $orderDetail->quantity = $item['quantity'];
    //         $orderDetail->price = $item['price'];
    //         $orderDetail->save();
    //     }

    //     // Clear the cart after successful checkout
    //     session()->forget('cart');

    //     // Redirect to the success page
    //     return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công');
    // }
}
