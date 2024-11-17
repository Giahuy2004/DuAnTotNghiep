<!-- resources/views/admin/blog/edit.blade.php -->
@extends('admin.layouts.app')
@section('content')
<div class="page-body">
    <div class="container">
        <h2>Chỉnh Sửa Bài Viết</h2>
        <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Tiêu Đề</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}" required>
            </div>

            <div class="form-group">
                <label for="content">Nội Dung</label>
                <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="form-group">
                <label for="cover_image">Hình Ảnh Bìa</label>
                @if($post->cover_image)
                    <img src="{{ Storage::url($post->cover_image) }}" alt="Cover Image" width="100">
                @endif
                <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
            </div>

            <div class="form-group">
                <label for="images">Hình Ảnh Trong Bài Viết</label>
                @if($post->images)
                    @foreach(json_decode($post->images) as $image)
                        <img src="{{ Storage::url($image) }}" alt="Post Image" width="100">
                    @endforeach
                @endif
                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Cập Nhật Bài Viết</button>
        </form>
    </div>
</div>

@endsection
