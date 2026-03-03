<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'name', 'price', 'image', 'description', 'unit', 'stock'];

    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function reviews() {
    return $this->hasMany(Review::class)->latest(); // Lấy mới nhất trước
}
}