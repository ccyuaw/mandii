<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Xem chi tiết hồ sơ bác sĩ
    public function showDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('users.doctors.show', compact('doctor'));
    }
}