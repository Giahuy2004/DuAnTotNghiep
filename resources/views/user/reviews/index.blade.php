@extends('layout')

@section('content')
    <h1>Đánh giá sản phẩm: {{ $product->name }}</h1>

    <!-- Hiển thị thông báo lỗi nếu người dùng chưa mua sản phẩm -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Hiển thị các đánh giá -->
    <div>
        @foreach ($reviews as $review)
            <div class="review">
                <strong>{{ $review->user->name }}</strong>
                <div>
                    <span>{{ $review->rating }} sao</span>
                </div>
                <div>{{ $review->comment }}</div>
                @if ($review->user_id == auth()->id())
                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Xóa đánh giá</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Form để thêm đánh giá mới -->
    @auth
        <h2>Đánh giá của bạn</h2>
        <form action="{{ route('reviews.store', $product->id) }}" method="POST">
            @csrf
            <div>
                <label for="rating">Điểm đánh giá</label>
                <select name="rating" id="rating">
                    <option value="1">1 sao</option>
                    <option value="2">2 sao</option>
                    <option value="3">3 sao</option>
                    <option value="4">4 sao</option>
                    <option value="5">5 sao</option>
                </select>
            </div>
            <div>
                <label for="comment">Bình luận</label>
                <textarea name="comment" id="comment" rows="4"></textarea>
            </div>
            <button type="submit">Gửi đánh giá</button>
        </form>
    @endauth
@endsection
