<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorPageController extends Controller
{
    // Hàm này dùng cho trang "Đặt lịch bác sĩ" (/doctors)
    public function index(Request $request)
    {
        $query = Doctor::with('specialty');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhereHas('specialty', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $doctors = $query->paginate(9);

        // Trả về view danh sách bác sĩ (Cần tạo file này ở bước 3)
        return view('users.doctors.index', compact('doctors'));
    }
    public function show($id)
    {
        $doctor = Doctor::with('specialty')->findOrFail($id);
        
        // Gợi ý bác sĩ khác cùng chuyên khoa
        $relatedDoctors = Doctor::where('specialty_id', $doctor->specialty_id)
            ->where('id', '!=', $id)
            ->limit(3)
            ->get();

        return view('users.doctors.show', compact('doctor', 'relatedDoctors'));
    }
}