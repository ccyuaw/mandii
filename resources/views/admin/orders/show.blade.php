@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Danh sách sản phẩm</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá mua</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset($item->product->image ?? 'images/no-image.png') }}" width="50" class="me-2 rounded">
                                        <span>{{ $item->product->name ?? 'Sản phẩm đã bị xóa' }}</span>
                                    </div>
                                </td>
                                <td>{{ number_format($item->price) }}đ</td>
                                <td>x{{ $item->quantity }}</td>
                                <td class="fw-bold">{{ number_format($item->price * $item->quantity) }}đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                <td class="fw-bold text-danger fs-5">{{ number_format($order->total_price) }}đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Cập nhật trạng thái</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <select name="status" class="form-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                    </form>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Thông tin giao hàng</h5>
                </div>
                <div class="card-body">
                    <p><strong>Người nhận:</strong> {{ $order->customer_name }}</p>
                    <p><strong>SĐT:</strong> {{ $order->customer_phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->customer_address }}</p>
                    <p><strong>Ghi chú:</strong> {{ $order->note ?? 'Không có' }}</p>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Thanh toán:</strong> {{ $order->payment_method }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@if($order->payment_status == 'unpaid' || $order->payment_status == 'failed')
    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center justify-between">
        <span class="text-red-700 font-bold">
            <i class="fa-solid fa-triangle-exclamation"></i> Đơn hàng chưa thanh toán
        </span>
        
        <form action="{{ route('payment.retry', ['type' => 'order', 'id' => $order->id]) }}" method="POST">
            @csrf
            <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-pink-700 shadow-lg shadow-pink-200">
                <i class="fa-solid fa-wallet"></i> Thanh toán lại bằng MoMo
            </button>
        </form>
    </div>
@endif
@endsection