@extends('admin.layouts.app')

@section('content')
{{-- <div class="page-body">
    <div class="container">
        <h2>Thêm Bài Viết</h2>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Tiêu Đề</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label for="content">Nội Dung</label>
                <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
            </div>

            <div class="form-group">
                <label for="cover_image">Hình Ảnh Bìa</label>
                <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
            </div>

            <div class="form-group">
                <label for="images">Hình Ảnh Trong Bài Viết</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Lưu Bài Viết</button>
        </form>
    </div>
</div> --}}
<div class="page-body">
    <div class="container-fluid">
        <div class="title-header">
            <h5>Thêm Bài Viết</h5>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header-2">
                                <h5>Thông Tin Bài Viết</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="theme-form theme-form-2 mega-form">
                                    @csrf
                                    <!-- Tiêu Đề -->
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-2 mb-0">Tiêu Đề</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="title" placeholder="Nhập tiêu đề bài viết" value="{{ old('title') }}" required>
                                        </div>
                                    </div>

                                    <!-- Nội Dung -->
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-2 mb-0">Nội Dung</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="content" rows="5" placeholder="Nhập nội dung bài viết" required>{{ old('content') }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Hình Ảnh Bìa -->
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-2 mb-0">Hình Ảnh Bìa</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="file" name="cover_image" accept="image/*" onchange="previewCoverImage()">
                                        </div>
                                    </div>

                                    <!-- Xem Trước Ảnh Bìa -->
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-2 mb-0">Xem Trước Ảnh Bìa</label>
                                        <div class="col-sm-10" id="coverImagePreview"></div>
                                    </div>

                                    <!-- Hình Ảnh Trong Bài Viết -->
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-2 mb-0">Hình Ảnh Trong Bài Viết</label>
                                        <div class="col-sm-10">
                                            <input class="form-control form-choose" type="file" name="images[]" multiple accept="image/*" onchange="previewPostImages()">
                                        </div>
                                    </div>

                                    <!-- Xem Trước Ảnh Trong Bài Viết -->
                                    <div class="mb-4 row align-items-center">
                                        <label class="form-label-title col-sm-2 mb-0">Xem Trước Hình Ảnh</label>
                                        <div class="col-sm-10" id="postImagesPreview"></div>
                                    </div>

                                    <!-- Nút Lưu -->
                                    <div class="row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <input type="submit" value="Lưu Bài Viết" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <footer class="footer">
                <div class="row">
                    <div class="col-md-12 footer-copyright text-center">
                        <p class="mb-0">Copyright 2021 © Voxo theme by pixelstrap</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>
<script>
    // Xem trước ảnh bìa
function previewCoverImage() {
    const input = document.querySelector('input[name="cover_image"]');
    const preview = document.getElementById('coverImagePreview');
    preview.innerHTML = '';

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '200px';
            img.style.marginTop = '10px';
            preview.appendChild(img);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Xem trước ảnh trong bài viết
function previewPostImages() {
    const input = document.querySelector('input[name="images[]"]');
    const preview = document.getElementById('postImagesPreview');
    preview.innerHTML = '';

    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100px';
                img.style.margin = '5px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
}

</script>
@endsection