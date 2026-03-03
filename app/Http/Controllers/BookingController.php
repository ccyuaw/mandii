<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\PaymentController; // 1. IMPORT PaymentController

class BookingController extends Controller
{
    // Hiển thị form đặt lịch
    public function create($doctor_id)
    {
        $doctor = Doctor::findOrFail($doctor_id);
        return view('users.booking.create', compact('doctor')); 
    }

    // Lưu thông tin đặt lịch
    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date_booking' => 'required|date|after_or_equal:today',
            'time_booking' => 'required',
            'note' => 'nullable|string|max:1000',
        ], [
            'date_booking.after_or_equal' => 'Ngày đặt lịch không được chọn quá khứ.',
        ]);

        // Kiểm tra xem có đơn nào đang pending không
        $checkPending = Appointment::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->exists();

        if ($checkPending) {
            return back()->withErrors(['limit' => 'Bạn đang có một lịch hẹn chờ duyệt/thanh toán. Vui lòng hoàn tất trước khi đặt tiếp.'])->withInput();
        }

        $doctor = Doctor::findOrFail($request->doctor_id);

        // 2. Xử lý thời gian
        $fullTime = $request->date_booking . ' ' . $request->time_booking;
        $appointmentTime = Carbon::parse($fullTime);

        // 3. Kiểm tra logic thời gian
        if ($appointmentTime->isPast()) {
            return back()->withErrors(['time_booking' => 'Thời gian hẹn phải lớn hơn thời gian hiện tại.'])->withInput();
        }

        // 4. Kiểm tra trùng lịch bác sĩ
        $exists = Appointment::where('doctor_id', $doctor->id)
            ->where('status', '!=', 'cancelled')
            ->where('appointment_time', $appointmentTime) 
            ->exists();

        if ($exists) {
            return back()->withErrors(['time_booking' => 'Giờ này bác sĩ đã bận, vui lòng chọn giờ khác.'])->withInput();
        }

        // 5. Lưu vào Database
        $appointment = Appointment::create([
            'user_id' => Auth::id(),
            'doctor_id' => $doctor->id,
            'appointment_time' => $appointmentTime,
            'symptoms' => $request->note, 
            'price' => $doctor->price ?? 0, 
            'status' => 'pending',
            'payment_status' => 'unpaid'
        ]);

        // 6. Chuyển hướng sang trang chọn phương thức thanh toán
        return redirect()->route('booking.payment', $appointment->id);
    }

    // --- Trang hiển thị thanh toán ---
    public function showPayment($id)
    {
        $appointment = Appointment::where('user_id', Auth::id())->findOrFail($id);
        
        // Nếu đã trả tiền rồi thì chuyển về lịch sử
        if($appointment->payment_status == 'paid') {
            return redirect()->route('booking.history')->with('info', 'Lịch hẹn này đã được thanh toán.');
        }

        return view('users.booking.payment', compact('appointment'));
    }

    // --- XỬ LÝ THANH TOÁN MOMO ---
    public function processPayment($id)
    {
        $appointment = Appointment::where('user_id', Auth::id())->findOrFail($id);

        // Gọi sang PaymentController để tạo link thanh toán MoMo
        // Tham số: 'booking' (loại), ID lịch hẹn, Số tiền
        $payment = new PaymentController();
        return $payment->createMomoPayment('booking', $appointment->id, $appointment->price);
    }

    // Xem lịch sử
    public function history()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->with('doctor')
            ->latest()
            ->paginate(10);

        return view('users.booking.history', compact('appointments'));
    }

    // Hủy lịch
    public function cancel($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'confirmed'])
            ->firstOrFail();

        $appointment->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Đã hủy lịch hẹn thành công.');
    }
    
}