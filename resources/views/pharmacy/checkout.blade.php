@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8 text-slate-800 text-center">Thanh toán đơn hàng</h1>

        {{-- ⚠️ SỬA ROUTE: Đảm bảo route này trùng với route trong web.php (checkout.process) --}}
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="flex flex-col md:flex-row gap-8">
                
                <div class="w-full md:w-2/3">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                        <h3 class="font-bold text-xl mb-4 border-b pb-2">1. Thông tin người nhận</h3>
                        
                        {{-- Hiển thị lỗi Validate nếu có --}}
                        @if ($errors->any())
                            <div class="bg-red-50 text-red-500 p-3 rounded mb-4 text-sm">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Họ tên *</label>
                                {{-- ⚠️ ĐÃ SỬA: name="name" để khớp với Controller --}}
                                <input type="text" name="name" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required value="{{ Auth::user()->name ?? old('name') }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Số điện thoại *</label>
                                {{-- ⚠️ ĐÃ SỬA: name="phone" --}}
                                <input type="text" name="phone" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required value="{{ Auth::user()->phone ?? old('phone') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Địa chỉ giao hàng *</label>
                            {{-- ⚠️ ĐÃ SỬA: name="address" --}}
                            <input type="text" name="address" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" required placeholder="Số nhà, đường, phường, quận..." value="{{ old('address') }}">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Ghi chú (Tùy chọn)</label>
                            <textarea name="note" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" rows="2">{{ old('note') }}</textarea>
                        </div>

                        <h3 class="font-bold text-xl mb-4 border-b pb-2 mt-8">2. Phương thức thanh toán</h3>
                        <div class="space-y-3">
                            {{-- Option 1: COD --}}
                            <label for="payment_cod" class="flex items-center gap-3 p-4 border rounded-lg cursor-pointer bg-slate-50 hover:bg-white hover:border-blue-400 transition">
                                <input type="radio" name="payment_method" id="payment_cod" value="cod" checked class="w-5 h-5 text-blue-600">
                                <div>
                                    <span class="font-bold block text-slate-800"><i class="fa-solid fa-truck-fast text-slate-500 mr-2"></i> Thanh toán khi nhận hàng (COD)</span>
                                    <span class="text-sm text-slate-500">Bạn sẽ thanh toán tiền mặt cho shipper khi nhận được hàng.</span>
                                </div>
                            </label>
                            
                            {{-- Option 2: MOMO (ĐÃ MỞ KHÓA) --}}
                            <label for="payment_momo" class="flex items-center gap-3 p-4 border rounded-lg cursor-pointer bg-pink-50 hover:bg-white hover:border-pink-500 transition border-pink-200">
                                <input type="radio" name="payment_method" id="payment_momo" value="momo" class="w-5 h-5 text-pink-600">
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold block text-pink-700">Thanh toán qua Ví MoMo </span>
                                        <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" alt="MoMo" class="h-6 object-contain">
                                    </div>
                                    <span class="text-sm text-pink-600">Quét mã QR để thanh toán an toàn, tiện lợi.</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/3">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 sticky top-24">
                        <h3 class="font-bold text-xl mb-4 border-b pb-2">Đơn hàng của bạn</h3>
                        
                        <div class="space-y-4 mb-4 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                            @php $total = 0; @endphp
                            {{-- Kiểm tra xem biến $cart có tồn tại không --}}
                            @if(session('cart'))
                                @foreach(session('cart') as $item)
                                    @php $total += $item['price'] * $item['quantity']; @endphp
                                    <div class="flex justify-between items-start text-sm border-b border-dashed pb-2 last:border-0">
                                        <div class="flex items-start gap-2">
                                            <span class="font-bold text-blue-600 bg-blue-50 px-2 rounded">{{ $item['quantity'] }}x</span>
                                            <span class="text-slate-700 w-40">{{ $item['name'] }}</span>
                                        </div>
                                        <span class="font-bold text-slate-800">{{ number_format($item['price'] * $item['quantity']) }}đ</span>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center text-slate-400 italic">Giỏ hàng trống</p>
                            @endif
                        </div>

                        <div class="border-t pt-4 space-y-2 bg-slate-50 p-4 rounded-lg">
                            <div class="flex justify-between text-slate-600">
                                <span>Tạm tính:</span>
                                <span>{{ number_format($total) }}đ</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Phí vận chuyển:</span>
                                <span class="text-green-600 font-bold">Miễn phí</span>
                            </div>
                            <div class="flex justify-between text-xl font-black text-blue-600 pt-2 border-t border-slate-200 mt-2">
                                <span>Tổng cộng:</span>
                                <span>{{ number_format($total) }}đ</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl mt-6 hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center justify-center gap-2">
                            <span>ĐẶT HÀNG NGAY</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('cart.index') }}" class="text-sm text-slate-500 hover:text-blue-600 hover:underline">
                                <i class="fa-solid fa-chevron-left mr-1"></i> Quay lại giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection