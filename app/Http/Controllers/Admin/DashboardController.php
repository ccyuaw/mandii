<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment; // Đảm bảo bạn đã có model này

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Lấy số liệu thống kê
        $totalDoctors = Doctor::count();
        $totalUsers = User::where('role', 'user')->count();
        
        // Nếu chưa có bảng appointments thì để tạm bằng 0 để không lỗi
        $totalAppointments = \Illuminate\Support\Facades\Schema::hasTable('appointments') 
                            ? Appointment::count() 
                            : 0;

        $totalRevenue = \Illuminate\Support\Facades\Schema::hasTable('appointments')
                            ? Appointment::sum('price') // Cộng tổng giá tiền
                            : 0;

        // 2. Lấy 5 lịch hẹn mới nhất (nếu có bảng)
        $recentAppointments = [];
        if (\Illuminate\Support\Facades\Schema::hasTable('appointments')) {
            $recentAppointments = Appointment::with(['user', 'doctor'])
                                    ->latest()
                                    ->take(5)
                                    ->get();
        }

        return view('admin.dashboard', compact(
            'totalDoctors', 
            'totalUsers', 
            'totalAppointments', 
            'totalRevenue',
            'recentAppointments'
        ));
    }
}