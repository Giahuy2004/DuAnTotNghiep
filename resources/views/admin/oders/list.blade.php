@extends('layout')

@section('content')
    <div class="container">
        <h2>Danh sách đơn hàng</h2>
        @if ($orders->isEmpty())
            <p>Không có đơn hàng nào.</p>
        @else
            @php
                $orderStatuses = [
                    'pending' => 'Chờ xác nhận',
                    'confirmed' => 'Đã xác nhận',
                    'shipping' => 'Đang giao hàng',
                    'delivered' => 'Đã giao thành công',
                    'canceled' => 'Đã hủy'
                ];
            @endphp
            <div class="row">
                @foreach ($orders as $order)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">ID Đơn hàng: {{ $order->id }}</h5>
                                <p class="card-text"><strong>Khách hàng:</strong> {{ $order->user->name ?? 'Khách vãng lai' }}</p>
                                <p class="card-text"><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                                <p class="card-text"><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                                <p class="card-text"><strong>Phương thức thanh toán:</strong> {{ $order->payment_method }}</p>
                                <p class="card-text"><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VND</p>
                                <p class="card-text"><strong>Trạng thái:</strong>
                                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-control d-inline" onchange="this.form.submit()">
                                            @foreach ($orderStatuses as $key => $label)
                                                <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </p>
                                <button class="btn btn-info" data-toggle="collapse" data-target="#orderDetails-{{ $order->id }}">
                                    Xem chi tiết
                                </button>
                                <div id="orderDetails-{{ $order->id }}" class="collapse mt-2">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Số lượng</th>
                                                <th>Giá</th>
                                                <th>Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->orderDetails as $detail)
                                                <tr>
                                                    @if($detail->product)
                                                        <td>{{ $detail->product->name }}</td>
                                                    @else
                                                        <td>Sản phẩm không tồn tại</td>
                                                    @endif
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>{{ number_format($detail->price, 0, ',', '.') }} VND</td>
                                                    <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} VND</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <style>
        
        </style>
@endsection
