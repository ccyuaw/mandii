@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-slate-800"><i class="fa-solid fa-cart-shopping text-blue-600"></i> Giỏ hàng của bạn</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('cart'))
        <div class="flex flex-col md:flex-row gap-8">
            <div class="w-full md:w-2/3 bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="p-4 font-semibold text-slate-600">Sản phẩm</th>
                            <th class="p-4 font-semibold text-slate-600 text-center">Giá</th>
                            <th class="p-4 font-semibold text-slate-600 text-center">Số lượng</th>
                            <th class="p-4 font-semibold text-slate-600 text-center">Tổng</th>
                            <th class="p-4 font-semibold text-slate-600"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0 @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr class="border-b border-slate-50 hover:bg-slate-50 transition" data-id="{{ $id }}">
                                <td class="p-4">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $details['image'] ? asset($details['image']) : 'https://via.placeholder.com/80' }}" class="w-16 h-16 object-cover rounded-md border">
                                        <div>
                                            <h4 class="font-bold text-slate-800">{{ $details['name'] }}</h4>
                                            <span class="text-xs text-slate-500">{{ $details['unit'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center">{{ number_format($details['price']) }}đ</td>
                                <td class="p-4 text-center">
                                    <input type="number" value="{{ $details['quantity'] }}" class="form-control w-16 text-center border rounded py-1 update-cart" min="1">
                                </td>
                                <td class="p-4 text-center font-bold text-blue-600">
                                    {{ number_format($details['price'] * $details['quantity']) }}đ
                                </td>
                                <td class="p-4 text-center">
                                    <button class="text-red-500 hover:text-red-700 remove-from-cart">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="w-full md:w-1/3">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 sticky top-24">
                    <h3 class="font-bold text-lg mb-4 text-slate-800">Cộng giỏ hàng</h3>
                    <div class="flex justify-between mb-2 text-slate-600">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($total) }}đ</span>
                    </div>
                    <div class="flex justify-between mb-4 text-slate-600">
                        <span>Giảm giá:</span>
                        <span>0đ</span>
                    </div>
                    <div class="border-t pt-4 flex justify-between items-center mb-6">
                        <span class="font-bold text-xl">Tổng cộng:</span>
                        <span class="font-bold text-2xl text-blue-600">{{ number_format($total) }}đ</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Tiến hành thanh toán
                    </a>
                    <a href="{{ route('pharmacy.index') }}" class="block w-full text-center py-3 mt-2 text-slate-500 hover:text-blue-600 text-sm">
                        <i class="fa-solid fa-arrow-left"></i> Tiếp tục mua thuốc
                    </a>
                </div>
            </div>
        </div>
        @else
            <div class="text-center py-20 bg-white rounded-xl shadow-sm">
                <i class="fa-solid fa-basket-shopping text-6xl text-slate-200 mb-4"></i>
                <p class="text-xl text-slate-500 mb-4">Giỏ hàng của bạn đang trống!</p>
                <a href="{{ route('pharmacy.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold hover:bg-blue-700 transition">
                    Mua thuốc ngay
                </a>
            </div>
        @endif
    </div>
</div>

{{-- Script xử lý AJAX cập nhật/xóa --}}
{{-- Script xử lý AJAX cập nhật/xóa --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(".update-cart").change(function (e) {
        e.preventDefault();
        var ele = $(this);
        
        $.ajax({
            url: "{{ route('cart.update') }}", // <--- Đã sửa: Dùng nháy kép " bao bên ngoài
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}', 
                id: ele.parents("tr").attr("data-id"), 
                quantity: ele.parents("tr").find(".update-cart").val() // Sửa lại selector để lấy đúng giá trị input
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        
        if(confirm("Bạn có chắc muốn xóa sản phẩm này?")) {
            $.ajax({
                url: "{{ route('cart.remove') }}", // <--- Đã sửa: Dùng nháy kép " bao bên ngoài
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
</script>
@endsection