<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;       // Model Đơn hàng thuốc
use App\Models\Appointment; // Model Lịch khám
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. LẤY THAM SỐ NGÀY TỪ FORM (Nếu không có thì lấy mặc định tháng này)
        $fromDate = $request->input('from_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $toDate   = $request->input('to_date', Carbon::now()->endOfDay()->format('Y-m-d'));

        // 2. QUERY DOANH THU THUỐC (ORDERS)
        // Chỉ lấy đơn đã thanh toán (paid) và nằm trong khoảng ngày chọn
        $orders = Order::select(
                DB::raw('DATE(created_at) as date'), 
                DB::raw('SUM(total_price) as total') // Lưu ý: Cột tổng tiền trong DB của bạn là 'total' hay 'total_price'? Hãy sửa lại cho đúng tên cột.
            )
            ->where('payment_status', 'paid') 
            ->whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->groupBy('date')
            ->get()
            ->keyBy('date'); // Đánh index mảng bằng ngày để dễ tìm

        // 3. QUERY DOANH THU KHÁM BỆNH (APPOINTMENTS)
        $appointments = Appointment::select(
                DB::raw('DATE(appointment_time) as date'), // Lưu ý: Cột ngày trong DB Appointment là 'appointment_date' hay 'appointment_time'?
                DB::raw('SUM(price) as total')
            )
            ->where('payment_status', 'paid')
            ->whereDate('appointment_time', '>=', $fromDate)
            ->whereDate('appointment_time', '<=', $toDate)
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        // 4. CHUẨN BỊ DỮ LIỆU CHO BIỂU ĐỒ & THẺ TỔNG
        $chartLabels   = []; // Nhãn ngày (trục hoành)
        $dataPharmacy  = []; // Dữ liệu cột thuốc
        $dataBooking   = []; // Dữ liệu cột khám
        
        $totalPharmacy = 0;  // Tổng tiền thuốc trong kỳ
        $totalBooking  = 0;  // Tổng tiền khám trong kỳ

        // Tạo một vòng lặp qua từng ngày trong khoảng thời gian đã chọn
        // Để đảm bảo ngày nào không có doanh thu thì biểu đồ vẫn hiện ngày đó (với giá trị 0)
        $period = CarbonPeriod::create($fromDate, $toDate);

        foreach ($period as $date) {
            $dateString  = $date->format('Y-m-d'); // Dùng để tìm trong mảng dữ liệu
            $displayDate = $date->format('d/m');   // Dùng để hiển thị lên biểu đồ

            // Lấy giá trị, nếu không có thì bằng 0
            $valOrder = $orders[$dateString]->total ?? 0;
            $valAppt  = $appointments[$dateString]->total ?? 0;

            // Push vào mảng biểu đồ
            $chartLabels[]  = $displayDate;
            $dataPharmacy[] = (float) $valOrder;
            $dataBooking[]  = (float) $valAppt;

            // Cộng dồn vào tổng
            $totalPharmacy += $valOrder;
            $totalBooking  += $valAppt;
        }

        $totalRevenue = $totalPharmacy + $totalBooking;

        // 5. TRẢ VỀ VIEW
        return view('admin.reports.index', compact(
            'fromDate', 'toDate',          // Để hiển thị lại trên input ngày
            'chartLabels',                 // Nhãn ngày cho biểu đồ
            'dataPharmacy', 'dataBooking', // Dữ liệu cho biểu đồ
            'totalPharmacy', 'totalBooking', 'totalRevenue' // Số liệu tổng
        ));
    }
}