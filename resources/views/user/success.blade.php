@extends('layout')

@section('content')

<div class="container my-5">
    <div class="container">
        <div class="header-media-group">
            <button class="header-user"><img src="{{ asset('img/user.png') }}" alt="user"></button>
            <button class="header-src"><i class="fas fa-search"></i></button>
        </div>
        
        <h1>Cảm ơn bạn đã đặt hàng!</h1>
        <p>Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.</p>

        <a href="{{ route('index') }}" class="btn-return">Quay lại trang chính</a>
    </div>
</div>


@endsection