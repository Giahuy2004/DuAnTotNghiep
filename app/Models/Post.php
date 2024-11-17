<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    // Định nghĩa các trường có thể được điền trong bảng (mass assignable)
    protected $fillable = [
        'title',
        'content',
        'cover_image',
        'images',
    ];

    // Đảm bảo rằng thuộc tính images được lưu dưới dạng mảng khi truy cập
    protected $casts = [
        'images' => 'array', // Biến images sẽ được tự động chuyển thành mảng khi truy xuất
    ];

    // Hàm xóa các hình ảnh liên quan khi xóa bài viết
    // public static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($post) {
    //         // Xóa ảnh bìa nếu có
    //         if ($post->cover_image) {
    //             Storage::delete($post->cover_image);
    //         }

    //         // Xóa các ảnh trong bài viết nếu có
    //         foreach ($post->images as $image) {
    //             Storage::delete($image);
    //         }
    //     });
    // }

    // Hàm lưu hình ảnh bìa và ảnh trong bài viết
    public function saveImages($coverImage, $images)
    {
        // Lưu hình ảnh bìa
        if ($coverImage) {
            $this->cover_image = $coverImage->store('public/cover_images');
        }

        // Lưu các ảnh trong bài viết
        $imagePaths = [];
        if ($images) {
            foreach ($images as $image) {
                $imagePaths[] = $image->store('public/post_images');
            }
        }
        $this->images = json_encode($imagePaths); // Lưu ảnh dưới dạng mảng JSON
    }
}
