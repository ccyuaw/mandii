<?php

namespace App\Http\Controllers\Admin;
use App\Models\Specialty;
use App\Http\Controllers\Controller;
use App\Models\Doctor; // Đừng quên import Model Doctor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    
    /**
     * Danh sách bác sĩ
     */
    public function index()
    {
        $doctors = Doctor::latest()->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * Form thêm bác sĩ mới
     */
    public function create()
    {
        // 1. Lấy tất cả chuyên khoa từ database
        $specialties = Specialty::all(); 

        // 2. Truyền biến $specialties sang view
        return view('admin.doctors.create', compact('specialties'));
    }
    /**
     * Lưu bác sĩ vào database
     */
    public function store(Request $request)
{
    // 1. Validate dữ liệu đầu vào (Thêm các trường mới)
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'specialty_id' => 'required|exists:specialties,id',
        'hospital' => 'required|string|max:255',
        'price' => 'required|numeric',
        'old_price' => 'nullable|numeric', // Mới
        'experience_years' => 'required|integer|min:0', // Mới
        'rating' => 'nullable|numeric|min:0|max:5', // Mới
        'consultation_count' => 'nullable|integer|min:0', // Mới
        'bio' => 'nullable|string',
        'work_history' => 'nullable|string', // Mới
        'education' => 'nullable|string', // Mới
        'image' => 'nullable|image|max:2048',
    ]);

    // 2. Xử lý ảnh (Giữ nguyên logic cũ)
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('doctors', 'public');
    }

    // 3. Lưu vào Database
    Doctor::create($data);

    return redirect()->route('admin.doctors.index')->with('success', 'Thêm bác sĩ thành công!');
}

    /**
     * Hiển thị chi tiết bác sĩ (nếu cần)
     */
    public function show($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('admin.doctors.show', compact('doctor'));
    }

    /**
     * Form chỉnh sửa bác sĩ
     */
    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Cập nhật thông tin bác sĩ
     */
    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'experience' => 'required|integer',
            'price' => 'required|numeric',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có ảnh mới
            if ($doctor->image) {
                Storage::disk('public')->delete($doctor->image);
            }
            $data['image'] = $request->file('image')->store('doctors', 'public');
        }

        $doctor->update($data);

        return redirect()->route('admin.doctors.index')->with('success', 'Cập nhật bác sĩ thành công!');
    }

    /**
     * Xóa bác sĩ
     */
    public function destroy($id)
{
    $doctor = Doctor::findOrFail($id);

    // 1. Xóa ảnh cũ nếu có (dọn dẹp bộ nhớ)
    if ($doctor->image) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($doctor->image);
    }

    // 2. QUAN TRỌNG: Xóa tất cả lịch hẹn của bác sĩ này trước
    // (Để tránh lỗi Foreign Key 1451)
    $doctor->appointments()->delete();

    // 3. Sau đó mới xóa Bác sĩ
    $doctor->delete();

    return back()->with('success', 'Đã xóa bác sĩ và các lịch hẹn liên quan.');
}
}