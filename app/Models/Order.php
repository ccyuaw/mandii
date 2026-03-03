<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'customer_name', 
        'customer_phone', 
        'customer_address', 
        'note', 
        'total_price', 
        'payment_method', 
        'status'
    ];

    // Một đơn hàng có nhiều sản phẩm (chi tiết đơn hàng)
    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    // Đơn hàng thuộc về một người dùng (có thể null nếu khách vãng lai)
    public function user() {
        return $this->belongsTo(User::class);
    }
}