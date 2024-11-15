@extends('layout')

@section('content')

 <section class="sec-product-detail bg-light p-5">
        <div class="container">
            <div class="row">
                <!-- Cột ảnh sản phẩm -->
                <div class="col-md-6 col-lg-7 mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            @if ($images && (is_array($images) || is_object($images)))
                                <!-- Ảnh lớn -->
                                <div class="text-center mb-4">
                                    <img src="{{ asset('storage/' . $images[0]) }}" class="img-fluid rounded"
                                        alt="{{ $product->name }}">
                                </div>

                                <!-- Ảnh nhỏ -->
                                <div class="row">
                                    @foreach ($images as $image)
                                        <div class="col-4">
                                            <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded shadow-sm"
                                                alt="{{ $product->name }}">
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>Không có hình ảnh nào.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Cột thông tin sản phẩm -->
                <div class="col-md-6 col-lg-5">
                    <div class="card border-0 shadow-sm p-4">
                        <h2 class="card-title text-primary mb-4">{{ $product->name }}</h2>

                        <!-- Giá -->
                        <div class="mb-3">
                            <p class="text-muted mb-1">Giá cũ:</p>
                            <span class="text-decoration-line-through text-muted">{{ number_format($product->price) }}
                                VND</span>
                        </div>
                        <div class="mb-4">
                            <p class="text-danger fw-bold mb-1">Giá sale:</p>
                            <span
                                class="fs-4 text-danger">{{ number_format($product->price - $product->price * ($product->sale_percentage / 100)) }}
                                VND</span>
                        </div>

                        <!-- Tuỳ chọn sản phẩm -->
                        <div class="mb-4">
                            <label for="size" class="form-label">Size</label>
                            <select class="form-select" id="size">
                                <option selected>Chọn kích thước</option>
                                <option value="S">Size S</option>
                                <option value="M">Size M</option>
                                <option value="L">Size L</option>
                                <option value="XL">Size XL</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="color" class="form-label">Màu sắc</label>
                            <select class="form-select" id="color">
                                <option selected>Chọn màu sắc</option>
                                <option value="red">Đỏ</option>
                                <option value="blue">Xanh</option>
                                <option value="white">Trắng</option>
                                <option value="grey">Xám</option>
                            </select>
                        </div>

                        <!-- Số lượng và nút Thêm vào giỏ -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="input-group me-3" style="width: 120px;">
                                <button class="btn btn-outline-secondary" type="button">-</button>
                                <input type="number" class="form-control text-center" value="1" min="1">
                                <button class="btn btn-outline-secondary" type="button">+</button>
                            </div>
                            <form action="{{ route('cart.add', ['itemId' => $product->id, 'quantity' => 1]) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
                            </form>
                        </div>

                        <!-- Ưu đãi -->
                        <div class="advantage-box mt-4">
                            <h5 class="text-white">Ưu Đãi Của Shop</h5>
                            <ul class="list-unstyled mb-0">
                                <li>✔ Giảm giá 10% cho đơn hàng đầu tiên</li>
                                <li>✔ Miễn phí vận chuyển cho đơn hàng từ 500.000 VND</li>
                                <li>✔ Quà tặng kèm cho khách hàng thân thiết</li>
                                <li>✔ Hỗ trợ trả góp 0% lãi suất khi đến tận cửa hàng</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mô tả sản phẩm -->
            <div class="mt-5 p-4 border rounded">
                <h3 class="text-primary mb-3">Mô Tả Sản Phẩm</h3>
                <p>{!! nl2br(e($product->content)) !!}</p>
            </div>
        </div>

        <style>
            .advantage-box {
                background-color: #FF0000;
                border: 2px solid black;
                padding: 1rem;
                border-radius: 0.5rem;
                color: white;
            }
        </style>
    </section>
    <!-- Related Products -->


    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}">
        $(document).ready(function() {
            $('.slick3').slick({
                dots: true,
                arrows: true,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1
            });
        });
    </script>

    </body>

@endsection
