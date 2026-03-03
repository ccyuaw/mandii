<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    // 1. Danh sách đơn hàng của TÔI
    public function index()
    {
        // Chỉ lấy đơn hàng của người đang đăng nhập (where user_id = Auth::id())
        $orders = Order::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->paginate(5); // Phân trang 5 đơn/trang
        
        return view('profile.orders.index', compact('orders'));
    }

    // 2. Xem chi tiết một đơn hàng cụ thể
    public function show($id)
    {
        // Tìm đơn hàng, nhưng phải đảm bảo đơn đó thuộc về người dùng này (để tránh xem trộm đơn người khác)
        $order = Order::where('user_id', Auth::id())
                      ->with('items.product') // Load kèm sản phẩm
                      ->findOrFail($id);

        return view('profile.orders.show', compact('order'));
    }

    // 3. Khách tự hủy đơn (Nếu đơn chưa giao)
    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status == 'pending') {
            $order->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'Đã hủy đơn hàng thành công!');
        }

        return redirect()->back()->with('error', 'Không thể hủy đơn hàng đang giao hoặc đã hoàn thành.');
    }
}