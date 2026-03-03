<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // 1. Danh sách đơn hàng
    public function index()
    {
        // Lấy danh sách đơn, sắp xếp mới nhất lên đầu, phân trang 10 đơn/trang
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // 2. Xem chi tiết đơn hàng
    public function show($id)
    {
        // Lấy đơn hàng kèm theo chi tiết sản phẩm (items) và thông tin sản phẩm (product)
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // 3. Cập nhật trạng thái đơn (Ví dụ: Chuyển từ "Chờ xử lý" sang "Đang giao")
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}