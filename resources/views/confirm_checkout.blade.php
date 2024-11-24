@extends('layout')

@section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<div class="container my-5">
    <h2 class="text-center mb-4">Thông tin thanh toán</h2>
    <form action="{{ route('user.checkout.process') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Customer Information Section -->
            <div class="col-md-6 mb-4">
                <div class="card p-4 shadow-sm">
                    <h4 class="mb-3">Thông tin khách hàng</h4>
                    <div class="form-group mb-3">
                        <label for="name">Họ và tên</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nhập họ tên của bạn" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="address">Địa chỉ giao hàng</label>
                        <input type="text" name="address" id="address" class="form-control" placeholder="Nhập địa chỉ giao hàng" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Nhập số điện thoại" required>
                    </div>
                </div>
            </div>

            <!-- Payment Method Section -->
            <div class="col-md-6 mb-4">
                <div class="card p-4 shadow-sm">
                    <h4 class="mb-3">Phương thức thanh toán</h4>
                    <button type="button" class="btn btn-outline-primary btn-block" onclick="togglePaymentOptions()">Chọn phương thức thanh toán</button>
                    <div id="payment-options" class="mt-3" style="display: none;">
                        <div class="form-check mb-3">
                            <input type="radio" name="payment_method" id="cod" value="cod" class="form-check-input" onclick="togglePaymentDetails('cod')" required>
                            <label for="cod" class="form-check-label">Thanh toán khi nhận hàng (COD)</label>
                        </div>
                        <div class="form-check mb-3">
                            <input type="radio" name="payment_method" id="qr" value="qr" class="form-check-input" onclick="togglePaymentDetails('qr')" required>
                            <label for="qr" class="form-check-label">Thanh toán bằng QR Code</label>
                        </div>
                    </div>
                    
                    <!-- Payment Method Details -->
                    <div id="payment-details-cod" class="payment-details mt-3" style="display: none;">
                        <div class="alert alert-info">
                            Thanh toán trực tiếp cho người giao hàng. Chỉ áp dụng cho đơn hàng nội địa.
                        </div>
                    </div>
                    <div id="payment-details-qr" class="payment-details mt-3" style="display: none;">
                        <div class="alert alert-info">
                            Quét mã QR bằng ứng dụng ngân hàng của bạn.
                            <img src="{{ asset('img/QR.jpg') }}" alt="QR Code" class="img-fluid mt-2" style="max-width: 200px;">
                            <p class="mt-2">Vui lòng hoàn thành thanh toán trong 15 phút.</p>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <strong>Lưu ý:</strong> Vui lòng kiểm tra lại thông tin trước khi xác nhận thanh toán. Sau khi xác nhận, bạn sẽ không thể thay đổi thông tin đơn hàng.
                    </div>
                    <div class="payment-icons mt-4 text-center d-flex justify-content-center">
                        <img src="{{ asset('img/01.jpg') }}" alt="COD" class="img-fluid" style="width: 50px; height: auto; margin-right: 20px;">
                        <img src="{{ asset('img/02.jpg') }}" alt="QR Payment" class="img-fluid" style="width: 50px; height: auto;">
                        <img src="{{ asset('img/03.jpg') }}" alt="QR Payment" class="img-fluid" style="width: 50px; height: auto;">
                        <img src="{{ asset('img/04.jpg') }}" alt="QR Payment" class="img-fluid" style="width: 50px; height: auto;">
                    </div>
                    
                    <div class="alert alert-secondary mt-4">
                        <strong>Bảo mật:</strong> Chúng tôi cam kết bảo mật thông tin thanh toán của bạn. Các giao dịch sẽ được xử lý thông qua các đối tác uy tín để đảm bảo an toàn tuyệt đối.
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Summary Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card p-4 shadow-sm">
                    <h4 class="mb-3">Sản phẩm của bạn</h4>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $item)
                                <tr>
                                    <td class="text-center">
                                        @if(isset($item['image']))
                                            @php
                                                $images = json_decode($item['image'], true);
                                            @endphp
                                            @if(is_array($images) && count($images) > 0)
                                                <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $item['name'] }}" class="img-thumbnail" style="width: 100px;">
                                            @else
                                                <img src="{{ asset('path/to/default-image.jpg') }}" alt="Ảnh không có" class="img-thumbnail" style="width: 100px;">
                                            @endif
                                        @else
                                            <img src="{{ asset('path/to/default-image.jpg') }}" alt="Ảnh không có" class="img-thumbnail" style="width: 100px;">
                                        @endif
                                    </td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} VNĐ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Display Total Price -->
                    <div class="text-right mb-3">
                        <h4>Tổng giá trị đơn hàng: <span class="fw-bold text-danger">{{ number_format($totalPrice, 0, ',', '.') }} VNĐ</span></h4>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success">Xác nhận thanh toán</button>
                    </div>
             
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Toggle payment options display
    function togglePaymentOptions() {
        var paymentOptions = document.getElementById('payment-options');
        paymentOptions.style.display = paymentOptions.style.display === 'none' ? 'block' : 'none';
    }

    // Toggle payment details based on selected payment method
    function togglePaymentDetails(method) {
        var codDetails = document.getElementById('payment-details-cod');
        var qrDetails = document.getElementById('payment-details-qr');

        if (method === 'cod') {
            codDetails.style.display = 'block';
            qrDetails.style.display = 'none';
        } else if (method === 'qr') {
            codDetails.style.display = 'none';
            qrDetails.style.display = 'block';
        }
    }
</script>

@endsection
