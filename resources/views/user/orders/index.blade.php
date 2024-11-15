@extends('layout')
@section('content')
    <div class="container">
        <h2>Danh sách đơn hàng của bạn</h2>
        
        @if ($orders->isEmpty())
            <p>Bạn chưa có đơn hàng nào.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Đơn hàng</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>{{ number_format($order->total_price, 0, ',', '.') }} VND</td>
                            <td>
                                @switch($order->status)
                                    @case('pending')
                                        Chờ xác nhận
                                        @break
                                    @case('confirmed')
                                        Đã xác nhận
                                        @break
                                    @case('shipping')
                                        Đang giao hàng
                                        @break
                                    @case('delivered')
                                        Đã giao thành công
                                        @break
                                    @case('canceled')
                                        Đã hủy
                                        @break
                                    @default
                                        Không xác định
                                @endswitch
                            </td>
                            <td><a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-info">Xem chi tiết</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
