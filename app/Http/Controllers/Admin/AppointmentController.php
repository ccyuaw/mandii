<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Hiển thị danh sách lịch hẹn
     */
    public function index()
    {
        // Lấy dữ liệu kèm thông tin User và Doctor để hiển thị tên
        // Sắp xếp lịch mới nhất lên đầu
        $appointments = Appointment::with(['user', 'doctor'])
            ->latest() // Tương đương orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Xử lý Duyệt hoặc Hủy lịch hẹn
     */
    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        // Validate dữ liệu gửi lên chỉ được là 'confirmed' hoặc 'cancelled'
        $request->validate([
            'status' => 'required|in:confirmed,cancelled'
        ]);

        $appointment->update(['status' => $request->status]);

        $msg = $request->status == 'confirmed' ? 'Đã duyệt lịch hẹn thành công!' : 'Đã hủy lịch hẹn!';
        
        return redirect()->back()->with('success', $msg);
    }
}