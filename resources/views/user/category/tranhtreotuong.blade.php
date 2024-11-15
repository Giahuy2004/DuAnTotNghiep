@extends('layout')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Sản Phẩm Tranh Treo Tường</h1>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-3 mb-4">
            <div class="product-card">
                @if($product->sale)
                <div class="sale-badge">Sale</div>
                @endif
                @if ($product->image) 
                @php
                    $images = json_decode($product->image);
                @endphp

                @if (is_array($images) || is_object($images))
                    @foreach ($images as $image)
                        <img src="{{ asset('storage/' . $image) }}" class="img-fluid" alt="Product Image" style="width: 250px; height: 250px;">
                        @break <!-- Chỉ hiển thị hình ảnh đầu tiên -->
                    @endforeach
                @else
                    <p>Invalid image data</p>
                @endif

            @else
                <p>No image available</p>
            @endif
            <h6 class="product-names">
                <a href="product-video.html">{{ $product->name }}</a>
            </h6>

                <h6 class="product-price">
                    @if ($product->sale_percentage)
                        <span class="old-price" style="text-decoration: line-through;">
                            {{ number_format($product->price, 0, ',', '.') }}<small> VND</small>
                        </span>
                        <br>
                        <span class="new-price" style="color:red;">
                            {{ number_format($product->price - ($product->price * ($product->sale_percentage / 100)), 0, ',', '.') }}<small> VND</small>
                        </span>
                    @else
                        <span>{{ number_format($product->price, 0, ',', '.') }}<small> VND</small></span>
                    @endif
                </h6>
                <div class="d-flex align-items-center"> 
                    <form id="addToCartForm" action="{{ route('cart.add', ['itemId' => $product->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                            </svg>
                        </button>
                    </form>
            
                    <a title="Chi tiết sản phẩm" href="{{ route('products.show', $product->id) }}" class="btn btn-secondary ms-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<style>
    .sale-badge{
        position: absolute;
    top: 10px;
    left: 10px;
    background: red;
    padding: 5px 10px;
    color: white;
    font-weight: bold;
    border-radius: 5px;
    }
    </style>
@endsection
