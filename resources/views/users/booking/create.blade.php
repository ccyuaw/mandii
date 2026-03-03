@extends('layouts.app')
@error('limit')
    <div class="alert alert-danger text-red-600 bg-red-100 p-3 rounded mb-4">
        ⚠️ {{ $message }}
    </div>
@enderror
@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4">
        {{-- Hiển thị thông báo lỗi chung nếu có --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <strong class="font-bold">Đã có lỗi xảy ra!</strong>
                <span class="block sm:inline">Vui lòng kiểm tra lại thông tin bên dưới.</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-blue-600 p-6 text-white text-center">
                <h2 class="text-2xl font-bold">Xác nhận đặt lịch tư vấn</h2>
                <p class="opacity-90">Vui lòng điền thông tin bên dưới</p>
            </div>
            
            <form action="{{ route('booking.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <img src="{{ $doctor->image ? asset('storage/'.$doctor->image) : 'https://via.placeholder.com/100' }}" class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <p class="text-sm text-slate-500">Đặt lịch với bác sĩ</p>
                        <h3 class="font-bold text-lg text-slate-800">{{ $doctor->name }}</h3>
                        <p class="text-blue-600 font-bold">{{ number_format($doctor->price) }}đ / lượt</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Ngày khám <span class="text-red-500">*</span></label>
                        <input type="date" 
                               name="date_booking" 
                               value="{{ old('date_booking') }}" 
                               min="{{ date('Y-m-d') }}"
                               required 
                               class="w-full rounded-lg border-slate-300 focus:ring-blue-500 @error('date_booking') border-red-500 @enderror">
                        @error('date_booking')
                            <p class="text-red-500 text-xs mt-1 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Giờ khám dự kiến <span class="text-red-500">*</span></label>
                        <input type="time" 
                               name="time_booking" 
                               value="{{ old('time_booking') }}" 
                               required 
                               class="w-full rounded-lg border-slate-300 focus:ring-blue-500 @error('time_booking') border-red-500 @enderror">
                        @error('time_booking')
                            <p class="text-red-500 text-xs mt-1 italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Triệu chứng / Lý do khám</label>
                    <textarea name="symptoms" 
                              rows="4" 
                              placeholder="Mô tả ngắn gọn tình trạng sức khỏe của bạn..." 
                              class="w-full rounded-lg border-slate-300 focus:ring-blue-500">{{ old('note') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-xl font-black text-lg shadow-lg hover:bg-blue-700 transition">
                    XÁC NHẬN ĐẶT LỊCH
                </button>
            </form>
        </div>
    </div>
</div>
@endsection