<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('admin.blog.index', compact('posts'));
    }
    public function list()
    {
        // Lấy tất cả bài viết
        $posts = Post::all();

        // Trả về view danh sách bài viết
        return view('user.blog.index', compact('posts'));
    }
    public function show($id)
    {
        // Lấy bài viết theo id
        $post = Post::findOrFail($id);

        // Trả về view chi tiết bài viết
        return view('user.blog.show', compact('post'));
    }
    public function create()
    {
        return view('admin.blog.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_in_content' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $featured_image = $request->file('featured_image') ? $request->file('featured_image')->store('public/featured_images') : null;
        $image_in_content = $request->file('image_in_content') ? $request->file('image_in_content')->store('public/images_in_content') : null;

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
            'featured_image' => $featured_image,
            'image_in_content' => $image_in_content
        ]);

        return redirect()->route('admin.blog.index');
    }
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.blog.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_in_content' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Xử lý ảnh bìa
        $featured_image = $request->file('featured_image') ? $request->file('featured_image')->store('public/featured_images') : $post->featured_image;

        // Xử lý các hình ảnh trong nội dung
        $image_in_content = $request->file('image_in_content')
            ? $request->file('image_in_content')->store('public/images_in_content')
            : $post->image_in_content;

        // Cập nhật bài viết
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
            'featured_image' => $featured_image,
            'image_in_content' => $image_in_content
        ]);

        return redirect()->route('admin.blog.index')->with('success', 'Bài viết đã được cập nhật!');
    }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('admin.blog.index');
    }
}
