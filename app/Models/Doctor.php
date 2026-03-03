<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    // Thêm 'specialty' và các trường khác vào đây
    protected $fillable = [
        'name',
        'specialty', // <--- Bạn đang bị thiếu dòng này hoặc viết sai chính tả
        'experience',
        'price',
        'bio',
        'image',
        'specialty_id',
    ];
    public function specialty()
    {
        // Khai báo: Một Bác sĩ thuộc về (belongsTo) một Chuyên khoa
        return $this->belongsTo(Specialty::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
