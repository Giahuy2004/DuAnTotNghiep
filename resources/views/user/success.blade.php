@extends('layout')

@section('content')
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 8000px;
            
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #4CAF50;
        }
        p {
            font-size: 18px;
            color: #555;
        }
        .header-media-group {
          
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header-logo img {
            height: 50px;
        }
        .header-user img {
            height: 30px;
        }
        .header-src {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-media-group">
            <button class="header-user"><img src="{{ asset('img/user.png') }}" alt="user"></button>
            <a href="{{ route('index') }}" class="header-logo"><img src="{{ asset('img/logo.png') }}" alt="logo"></a>
            <button class="header-src"><i class="fas fa-search"></i></button>
        </div>
        
        <h1>Cảm ơn bạn đã đặt hàng!</h1>
        <p>Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.</p>

        <a href="{{ route('index') }}" class="btn-return">Quay lại trang chính</a>
    </div>
</body>
</html>

@endsection