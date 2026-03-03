@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">
                <a href="{{ route('my_orders.index') }}" class="text-slate-400 hover:text-blue-600 mr-2"><i class="fa-solid fa-arrow-left"></i></a>
                Chi tiết đơn hàng #{{ $order->id }}
            </h1>
            
            @if($order->status == 'pending')
                <form action="{{ route('my_orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn này?');">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-4 py-2 rounded-lg font-bold transition border border-red-200">
                        Hủy đơn hàng
                    </button>
                </form>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-4">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                    <h3 class="font-bold text-lg mb-4 text-slate-800 border-b pb-2">Sản phẩm đã mua</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset($item->product->image ?? 'images/no-image.png') }}" class="w-16 h-16 object-cover rounded-md border">
                                <div>
                                    <h4 class="font-bold text-slate-700">{{ $item->product->name ?? 'Sản phẩm đã xóa' }}</h4>
                                    <p class="text-sm text-slate-500">Đơn giá: {{ number_format($item->price) }}đ</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="block font-bold">x{{ $item->quantity }}</span>
                                <span class="block font-bold text-blue-600">{{ number_format($item->price * $item->quantity) }}đ</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="border-t mt-4 pt-4 flex justify-between items-center">
                        <span class="font-bold text-xl text-slate-800">Tổng tiền thanh toán</span>
                        <span class="font-bold text-2xl text-blue-600">{{ number_format($order->total_price) }}đ</span>
                    </div>
                </div>
            </div>

            <div class="md:col-span-1">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 sticky top-24">
                    <h3 class="font-bold text-lg mb-4 text-slate-800 border-b pb-2">Thông tin nhận hàng</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="block text-slate-500">Người nhận:</span>
                            <span class="font-medium text-slate-800">{{ $order->customer_name }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-500">Số điện thoại:</span>
                            <span class="font-medium text-slate-800">{{ $order->customer_phone }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-500">Địa chỉ:</span>
                            <span class="font-medium text-slate-800">{{ $order->customer_address }}</span>
                        </div>
                        <div>
                            <span class="block text-slate-500">Ghi chú:</span>
                            <span class="font-medium text-slate-800 italic">{{ $order->note ?? 'Không có' }}</span>
                        </div>
                        <div class="pt-3 border-t">
                             <span class="block text-slate-500">Phương thức thanh toán:</span>
                             <span class="font-bold text-slate-800">{{ $order->payment_method }}</span>
                        </div>
                        <div>
                             <span class="block text-slate-500">Trạng thái:</span>
                             @if($order->status == 'pending')
                                 <span class="text-yellow-600 font-bold">Chờ xử lý</span>
                             @elseif($order->status == 'shipping')
                                 <span class="text-blue-600 font-bold">Đang giao hàng</span>
                             @elseif($order->status == 'completed')
                                 <span class="text-green-600 font-bold">Hoàn thành</span>
                             @else
                                 <span class="text-red-600 font-bold">Đã hủy</span>
                             @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection