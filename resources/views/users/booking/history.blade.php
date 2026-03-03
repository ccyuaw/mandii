@extends('layouts.app')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Lịch sử đặt khám của bạn</h2>
        
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-100">
            
            @if($appointments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-blue-50 text-blue-800">
                            <tr>
                                <th class="p-4 font-bold whitespace-nowrap">Thời gian</th>
                                <th class="p-4 font-bold whitespace-nowrap">Bác sĩ</th>
                                <th class="p-4 font-bold whitespace-nowrap">Giá khám</th>
                                <th class="p-4 font-bold whitespace-nowrap">Trạng thái / Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
    @foreach($appointments as $app)
    <tr class="hover:bg-slate-50 transition">
        {{-- Cột 1: Thời gian --}}
        <td class="p-4">
            <div class="font-bold text-slate-700">
                {{ \Carbon\Carbon::parse($app->appointment_date)->format('d/m/Y') }}
            </div>
            <div class="text-sm text-slate-500 font-medium">
                {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i') }}
            </div>
        </td>

        {{-- Cột 2: Bác sĩ --}}
        <td class="p-4">
            <div class="font-bold text-slate-800">{{ $app->doctor->name }}</div>
            <div class="text-xs text-slate-500 bg-slate-100 inline-block px-2 py-0.5 rounded mt-1">
                {{ $app->doctor->specialty->name ?? 'Chuyên khoa' }}
            </div>
        </td>

        {{-- Cột 3: Giá --}}
        <td class="p-4 font-bold text-blue-600">
            {{ number_format($app->price) }}đ
        </td>

        {{-- Cột 4: Trạng thái & Hành động --}}
        <td class="p-4 align-top space-y-2"> {{-- Thêm space-y-2 để các nút cách nhau ra --}}
            
            {{-- 1. HIỆN TRẠNG THÁI --}}
            @if($app->status == 'pending')
                <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold border border-yellow-200">
                    ⏳ Chờ duyệt
                </span>
            @elseif($app->status == 'accepted' || $app->status == 'confirmed')
                <span class="inline-block px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold border border-green-200">
                    ✅ Đã xác nhận
                </span>
            @elseif($app->status == 'cancelled')
                <span class="inline-block px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold border border-red-200">
                    ❌ Đã hủy
                </span>
            @elseif($app->status == 'completed')
                <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-bold border border-gray-200">
                    🏁 Đã hoàn thành
                </span>
            @endif

            {{-- 2. NÚT THANH TOÁN LẠI (Nếu chưa trả tiền và chưa hủy) --}}
            @if($app->payment_status == 'failed' && $app->status != 'cancelled')
                <div class="mt-1">
                    <form action="{{ route('payment.retry', ['type' => 'booking', 'id' => $app->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-red-700 shadow-sm transition flex items-center gap-1 justify-center">
                            <i class="fa-solid fa-triangle-exclamation"></i> Thanh toán lại
                        </button>
                    </form>
                    <p class="text-[10px] text-red-500 mt-1 italic text-center">Giao dịch trước đó bị lỗi</p>
                </div>
            @endif

            {{-- 3. CÁC NÚT HÀNH ĐỘNG KHÁC --}}
            @if($app->status == 'pending')
                {{-- Nút Hủy --}}
                <form action="{{ route('booking.cancel', $app->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn hủy lịch này?');" class="mt-1">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold underline bg-transparent border-none cursor-pointer p-0">
                        Hủy lịch
                    </button>
                </form>
            @elseif(($app->status == 'accepted' || $app->status == 'confirmed') && $app->payment_status == 'paid')
                {{-- Nút Chat (Chỉ hiện khi đã xác nhận VÀ đã trả tiền) --}}
                <a href="{{ route('chat.index', $app->id) }}" class="mt-1 inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-3 py-2 rounded-lg transition shadow-sm no-underline">
                    <i class="fa-solid fa-comments"></i> Vào phòng Chat
                </a>
            @endif

        </td>
    </tr>
    @endforeach
</tbody>
                    </table>
                </div>

                {{-- Phân trang (Nếu có) --}}
                <div class="p-4 border-t border-slate-50">
                    {{ $appointments->links() }}
                </div>

            @else
                {{-- Trạng thái trống --}}
                <div class="py-16 text-center text-slate-500">
                    <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-regular fa-calendar-xmark text-4xl text-slate-300"></i>
                    </div>
                    <p class="text-lg font-medium text-slate-600">Bạn chưa đặt lịch khám nào.</p>
                    <a href="{{ route('doctors.index') }}" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-full font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Đặt khám ngay
                    </a>
                </div>
            @endif
           
        </div>
    </div>
</div>
@endsection