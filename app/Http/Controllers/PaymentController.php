<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
class PaymentController extends Controller
{
    // 1. Hàm tạo thanh toán chung (Dùng cho cả Thuốc & Lịch khám)
    // $type: 'order' hoặc 'booking'
    // $id: ID của đơn hàng hoặc lịch hẹn
    // $amount: Số tiền cần thanh toán
    public function createMomoPayment($type, $id, $amount)
    {
        $endpoint    = env('MOMO_ENDPOINT');
        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey   = env('MOMO_ACCESS_KEY');
        $secretKey   = env('MOMO_SECRET_KEY');

        // Tạo mã đơn hàng có tiền tố để phân biệt
        // Ví dụ: ORDER_55_170000 hoặc BOOKING_22_170000
        $prefix = ($type == 'order') ? 'ORDER' : 'BOOKING';
        $orderId = $prefix . '_' . $id . '_' . time(); 
        
        $requestId   = (string)time();
        $orderInfo   = ($type == 'order') ? "Thanh toán đơn thuốc #$id" : "Phí khám bệnh #$id";
        $redirectUrl = route('momo.callback'); // Cùng quay về 1 chỗ
        $ipnUrl      = route('momo.callback');
        $amount      = (string)$amount;
        $requestType = "payWithATM"; 
        $extraData   = "";

        // Tạo chữ ký
        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Mandi Health",
            'storeId'     => "MandiStore",
            'requestId'   => $requestId,
            'amount'      => $amount,
            'orderId'     => $orderId,
            'orderInfo'   => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl'      => $ipnUrl,
            'lang'        => 'vi',
            'extraData'   => $extraData,
            'requestType' => $requestType,
            'signature'   => $signature
        ];

        try {
            $result = Http::post($endpoint, $data);
            $jsonResult = $result->json();

            if (isset($jsonResult['payUrl'])) {
                return redirect()->to($jsonResult['payUrl']);
            }
            return redirect()->back()->with('error', $jsonResult['message'] ?? 'Lỗi MoMo');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi kết nối MoMo');
        }
    }

    // 2. Xử lý Callback (Quan trọng nhất)
    public function momoCallback(Request $request)
    {
        // Tách chuỗi orderId: BOOKING_22_1700... thành mảng
        // $parts[0] = BOOKING (Loại)
        // $parts[1] = 22 (ID Gốc)
        $parts = explode('_', $request->orderId);
        
        if (count($parts) < 2) {
            return redirect()->route('home')->with('error', 'Dữ liệu thanh toán không hợp lệ.');
        }

        $type = $parts[0]; // 'ORDER' hoặc 'BOOKING'
        $id   = $parts[1]; // ID thật trong database

        if ($request->resultCode == 0) {
            // --- TRƯỜNG HỢP 1: MUA THUỐC ---
            if ($type == 'ORDER') {
                $order = Order::find($id);
                if ($order) {
                    $order->update(['status' => 'shipping', 'payment_status' => 'paid']);
                    session()->forget('cart');
                    return redirect()->route('my_orders.index')->with('success', 'Thanh toán đơn thuốc thành công!');
                }
            } 
            // --- TRƯỜNG HỢP 2: ĐẶT LỊCH KHÁM ---
            elseif ($type == 'BOOKING') {
                $appointment = Appointment::find($id);
                if ($appointment) {
                    $appointment->update(['status' => 'pending', 'payment_status' => 'paid']);
                    return redirect()->route('booking.history')->with('success', 'Thanh toán phí khám thành công! Bác sĩ sẽ sớm xác nhận.');
                }
            }
        } else {
            // Thanh toán thất bại
            return redirect()->route('home')->with('error', 'Giao dịch bị hủy hoặc thất bại.');
        }

        return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng/lịch khám.');
    }
    public function retryPayment($type, $id)
    {
        $amount = 0;

        // TRƯỜNG HỢP 1: NẾU LÀ ĐƠN THUỐC (ORDER)
        if ($type == 'order') {
            // Tìm đơn hàng
            $order = Order::where('user_id', Auth::id())->findOrFail($id);
            
            // Kiểm tra an toàn
            if ($order->payment_status == 'paid') {
                return redirect()->back()->with('info', 'Đơn hàng này đã được thanh toán rồi!');
            }

            // Gán số tiền
            $amount = $order->total_price;
        } 
        
        // TRƯỜNG HỢP 2: NẾU LÀ ĐẶT LỊCH (BOOKING)
        elseif ($type == 'booking') {
            // 🔥 QUAN TRỌNG: Phải tìm $appointment ở đây thì mới có biến để dùng
            $appointment = Appointment::where('user_id', Auth::id())->findOrFail($id);
            
            // Kiểm tra an toàn (Bây giờ $appointment đã tồn tại nên không bị lỗi nữa)
            if ($appointment->payment_status == 'paid') {
                return redirect()->back()->with('info', 'Lịch hẹn này đã được thanh toán rồi!');
            }

            // Gán số tiền
            $amount = $appointment->price;
        } 
        
        // TRƯỜNG HỢP 3: SAI LOẠI THANH TOÁN
        else {
            return redirect()->back()->with('error', 'Loại thanh toán không hợp lệ');
        }

        // Gọi hàm tạo thanh toán MoMo chung
        return $this->createMomoPayment($type, $id, $amount);
    }
    
}