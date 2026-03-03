<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    // 1. Hiển thị form thanh toán
    public function index()
    {
        $cart = session()->get('cart');
        if(!$cart || count($cart) == 0) {
            return redirect()->route('pharmacy.index')->with('error', 'Giỏ hàng trống!');
        }
        
        // ✅ GIỮ NGUYÊN ĐƯỜNG DẪN VIEW CỦA BẠN
        return view('pharmacy.checkout', compact('cart'));
    }

    // 2. Xử lý đặt hàng
    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        // ⚠️ Lưu ý: Nếu trong View bạn để name="name" thì ở đây validate 'name'.
        // Nếu bạn giữ view cũ (name="customer_name") thì sửa lại dòng dưới thành 'customer_name'
        $request->validate([
            'name' => 'required',     // Hoặc 'customer_name' => 'required'
            'phone' => 'required',    // Hoặc 'customer_phone' => 'required'
            'address' => 'required',  // Hoặc 'customer_address' => 'required'
            'payment_method' => 'required',
        ]);

        // 2. Tính tổng tiền
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        if ($total == 0) {
            return redirect()->back()->with('error', 'Giỏ hàng trống!');
        }

        // 3. Tạo Đơn hàng
        // Map dữ liệu từ Form vào Database
        $order = Order::create([
            'user_id' => Auth::id(), 
            // Nếu form là name="name" thì dùng $request->name
            // Nếu form là name="customer_name" thì dùng $request->customer_name
            'customer_name' => $request->name,       
            'customer_phone' => $request->phone,     
            'customer_address' => $request->address, 
            'note' => $request->note,
            'total_price' => $total,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'payment_status' => 'unpaid'
        ]);

        // 4. Lưu chi tiết đơn hàng
        foreach($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        // 5. Xóa giỏ hàng ngay lập tức
        session()->forget('cart');

        // 6. Xử lý Thanh toán MoMo
        if ($request->payment_method == 'momo') {
            // Gọi sang route retryPayment để tạo link thanh toán
            return redirect()->route('payment.retry', [
                'type' => 'order', 
                'id' => $order->id
            ]);
        }

        // 7. Nếu là COD
        return redirect()->route('my_orders.index')->with('success', 'Đặt hàng thành công! Đơn hàng đang được xử lý.');
    }
}