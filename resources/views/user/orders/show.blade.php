@extends('layout')

@section('content')
<div class="container">
    <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>

    <div class="row mb-4">
        <div class="col-md-6">
            <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y') }}
        </div>
        <div class="col-md-6">
            <strong>Trạng thái:</strong>
            @switch($order->status)
                @case('pending') Chờ xác nhận @break
                @case('confirmed') Đã xác nhận @break
                @case('shipping') Đang giao hàng @break
                @case('delivered') Đã giao thành công @break
                @case('canceled') Đã hủy @break
                @default Không xác định
            @endswitch
        </div>
    </div>

    <h4>Danh sách sản phẩm</h4>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->product_name }}</td>
                    <td>{{ number_format($detail->price, 0, ',', '.') }} VND</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row mt-4">
        <div class="col-md-6">
            <strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VND
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('user.orders.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>
@endsection
