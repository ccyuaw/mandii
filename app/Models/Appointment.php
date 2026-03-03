<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id', 
    'doctor_id', 
    'appointment_time', 
    'symptoms', // Lưu ý: Nếu database bạn đặt là 'symptoms' thì sửa ở đây và ở controller dòng create
    'status', 
    'price'
];

    // 1 lịch hẹn thuộc về 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 1 lịch hẹn thuộc về 1 bác sĩ
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}