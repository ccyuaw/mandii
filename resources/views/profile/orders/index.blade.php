@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-slate-800">Lịch sử đơn hàng</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4 border border-green-200">
                <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($orders->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-100 border-b border-slate-200 text-slate-600">
                        <tr>
                            <th class="p-4">Mã đơn</th>
                            <th class="p-4">Ngày đặt</th>
                            <th class="p-4">Tổng tiền</th>
                            <th class="p-4">Trạng thái</th>
                            <th class="p-4 text-right">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($orders as $order)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-bold text-blue-600">#{{ $order->id }}</td>
                            <td class="p-4 text-slate-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-4 font-bold">{{ number_format($order->total_price) }}đ</td>
                            <td class="p-4">
                                @if($order->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Chờ xử lý</span>
                                @elseif($order->status == 'shipping')
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Đang giao</span>
                                @elseif($order->status == 'completed')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Hoàn thành</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Đã hủy</span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('my_orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Xem chi tiết <i class="fa-solid fa-arrow-right ml-1"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $orders->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-xl border border-slate-100">
                <i class="fa-solid fa-receipt text-6xl text-slate-200 mb-4"></i>
                <p class="text-slate-500 mb-4">Bạn chưa có đơn hàng nào.</p>
                <a href="{{ route('pharmacy.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold hover:bg-blue-700 transition">
                    Mua thuốc ngay
                </a>
            </div>
        @endif
    </div>
</div>
@endsection