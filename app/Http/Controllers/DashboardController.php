<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // CŨ (nguyên nhân gây lỗi): 
        // return view('users.dashboard'); 

        // MỚI (Sửa lại cho đúng nơi chứa file):
        return view('dashboard'); 
    }
}