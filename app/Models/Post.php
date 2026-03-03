<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // 1. Cho phép lưu các cột này vào Database
    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'image',
        'user_id',
        'is_published'
    ];

    // 2. Khai báo mối quan hệ: Một bài viết thuộc về một User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}