<?php

namespace App\Models;

use App\Models\admin\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    // Các thuộc tính có thể gán giá trị
    protected $fillable = ['user_id', 'product_id', 'rating', 'comment'];

    // Mối quan hệ với người dùng (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mối quan hệ với sản phẩm (Product)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
