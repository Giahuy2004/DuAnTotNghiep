<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Hiển thị tất cả bài viết
    public function index()
    {
        $posts = Post::all();
        return view('admin.blog.index', compact('posts'));
    }
    public function userBlog()
    {
        // Lấy tất cả bài viết
        $posts = Post::all();

        // Trả về view cho trang người dùng
        return view('user.blog.index', compact('posts'));  // Đảm bảo rằng bạn truyền đúng biến 'posts'
    }
    public function show(Post $post)
    {
        return view('user.blog.show', compact('post'));
    }
    // Hiển thị form tạo bài viết mới
    public function create()
    {
        return view('admin.blog.add');
    }
    // Lưu bài viết mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Xử lý hình ảnh bìa
        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('public/cover_images');
        }

        // Xử lý các ảnh trong bài viết
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('public/post_images');
            }
        }

        // Lưu bài viết
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'cover_image' => $coverImagePath,
            'images' => json_encode($imagePaths),
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Bài viết đã được xóa thành công.');
    }

    // Hiển thị form chỉnh sửa bài viết
    public function edit(Post $post)
    {
        return view('admin.blog.edit', compact('post'));
    }

    // Cập nhật bài viết
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Xử lý hình ảnh bìa
        if ($request->hasFile('cover_image')) {
            // Xóa hình ảnh bìa cũ
            if ($post->cover_image) {
                Storage::delete($post->cover_image);
            }
            $coverImagePath = $request->file('cover_image')->store('public/cover_images');
        } else {
            $coverImagePath = $post->cover_image;
        }

        // Xử lý các ảnh trong bài viết
        $imagePaths = $post->images ? json_decode($post->images, true) : [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('public/post_images');
            }
        }

        // Cập nhật bài viết
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'cover_image' => $coverImagePath,
            'images' => json_encode($imagePaths),
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Bài viết đã được xóa thành công.');
    }

    // Xóa bài viết
    public function destroy(Post $post)
    {
        if ($post->cover_image) {
            Storage::delete($post->cover_image);
        }
        $images = json_decode($post->images, true);
        foreach ($images as $image) {
            Storage::delete($image);
        }

        $post->delete();


        return redirect()->route('admin.blog.index')->with('success', 'Bài viết đã được xóa thành công.');
    }
}
