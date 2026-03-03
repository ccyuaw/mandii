<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable = ['name', 'description'];

    // (Tùy chọn) Một chuyên khoa có nhiều bác sĩ
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}