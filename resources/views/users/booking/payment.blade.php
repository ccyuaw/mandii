@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-blue-600 p-6 text-center text-white">
                <h1 class="text-2xl font-bold mb-2">Thanh toán phí tư vấn</h1>
                <p class="opacity-90">Hoàn tất thanh toán để kết nối với Bác sĩ</p>
            </div>

            <div class="p-8">
                <div class="flex justify-between items-center border-b pb-4 mb-6">
                    <div>
                        <p class="text-slate-500 text-sm">Bác sĩ</p>
                        <p class="font-bold text-lg text-slate-800">{{ $appointment->doctor->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-slate-500 text-sm">Phí tư vấn</p>
                        <p class="font-bold text-xl text-blue-600">{{ number_format($appointment->price) }}đ</p>
                    </div>
                </div>

                <form action="{{ route('booking.payment.process', $appointment->id) }}" method="POST">
                    @csrf
                    <h3 class="font-bold text-slate-700 mb-4">Chọn phương thức thanh toán:</h3>
                    
                    <div class="space-y-3 mb-8">
                        <label class="flex items-center p-4 border rounded-xl cursor-pointer hover:bg-blue-50 transition {{ old('method') == 'vnpay' ? 'border-blue-500 bg-blue-50' : 'border-slate-200' }}">
                            <input type="radio" name="method" value="vnpay" class="w-5 h-5 text-blue-600" checked>
                            <span class="ml-3 font-medium">Thẻ ATM / Banking (VNPAY)</span>
                        </label>
                        
                        <label class="flex items-center p-4 border rounded-xl cursor-pointer hover:bg-blue-50 transition">
                            <input type="radio" name="method" value="momo" class="w-5 h-5 text-blue-600">
                            <span class="ml-3 font-medium">Ví Momo</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Thanh toán {{ number_format($appointment->price) }}đ
                    </button>
                    
                    <a href="{{ route('home') }}" class="block text-center mt-4 text-slate-500 hover:text-blue-600">Hủy & Quay lại sau</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection