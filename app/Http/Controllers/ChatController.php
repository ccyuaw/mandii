<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // 1. Vào phòng chat
    public function index($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        // Check 1: Bảo mật quyền truy cập (Chính chủ hoặc Admin)
        if (Auth::id() != $appointment->user_id && Auth::user()->role != 'admin') {
            abort(403, 'Bạn không có quyền truy cập cuộc hội thoại này.');
        }

        // Check 2: LOGIC CHẶN CHAT (Nếu chưa thanh toán thì không cho vào)
        // Lưu ý: Admin vẫn được vào để hỗ trợ
        if ($appointment->payment_status == 'unpaid' && Auth::user()->role != 'admin') {
            return redirect()->route('booking.payment', $appointment->id)
                             ->with('error', 'Vui lòng thanh toán phí tư vấn để bắt đầu chat.');
        }

        return view('chat.index', compact('appointment'));
    }

    // 2. API lấy tin nhắn
    public function fetchMessages($appointmentId)
    {
        // Có thể thêm check thanh toán ở đây nữa nếu muốn bảo mật API kỹ hơn
        
        $messages = Message::where('appointment_id', $appointmentId)
            ->with('user')
            ->get();

        return response()->json($messages);
    }

    // 3. Gửi tin nhắn
    public function sendMessage(Request $request, $appointmentId)
    {
        $request->validate(['message' => 'required']);
        
        // Check kỹ: Chưa thanh toán thì không được gửi tin
        $appointment = Appointment::findOrFail($appointmentId);
        if ($appointment->payment_status == 'unpaid' && Auth::user()->role != 'admin') {
             return response()->json(['status' => 'Error', 'message' => 'Unpaid appointment'], 403);
        }

        $message = Message::create([
            'appointment_id' => $appointmentId,
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        return response()->json(['status' => 'Message Sent!']);
    }

    // 4. Admin Chat View
    public function adminChat($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        if (Auth::user()->role != 'admin') {
             abort(403, 'Chỉ Admin mới được truy cập trang này.');
        }

        return view('admin.chat.show', compact('appointment'));
    }
}