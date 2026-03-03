@extends('layouts.admin')

@section('content')
<div class="flex min-h-screen bg-slate-100 font-sans">
    
    {{-- SIDEBAR --}}
    <aside class="w-64 bg-slate-900 text-white hidden md:block shrink-0 sticky top-0 h-screen overflow-y-auto">
        <div class="p-6">
            <h2 class="text-2xl font-black text-blue-500 tracking-tighter">ADMIN</h2>
            <p class="text-xs text-slate-400">Quản lý hệ thống Mandi</p>
        </div>
        <nav class="mt-4 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-600 rounded-xl text-white font-bold shadow-lg shadow-blue-900/50">
                <i class="fa-solid fa-chart-line"></i> Tổng quan
            </a>
            
            {{-- Link nhảy xuống biểu đồ --}}
            <a href="#revenue-chart-section" class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-xl transition font-medium">
                <i class="fa-solid fa-chart-pie"></i> Báo cáo thống kê
            </a>

            <div class="border-t border-slate-800 my-2"></div>

            <a href="{{ route('admin.doctors.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-xl transition font-medium">
                <i class="fa-solid fa-user-doctor"></i> Quản lý Bác sĩ
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-xl transition font-medium">
                <i class="fa-solid fa-users"></i> Quản lý Người dùng
            </a>
        </nav>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 p-8 overflow-y-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Tổng quan hệ thống</h1>
            <div class="text-sm text-slate-500 bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-100">
                📅 Hôm nay: <span class="font-bold text-slate-700">{{ date('d/m/Y') }}</span>
            </div>
        </div>

        {{-- 1. CARDS SỐ LIỆU --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Card Bác sĩ --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Tổng bác sĩ</p>
                    <p class="text-3xl font-black text-slate-800">{{ $totalDoctors }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 text-xl"><i class="fa-solid fa-user-doctor"></i></div>
            </div>

            {{-- Card Khách hàng --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Khách hàng</p>
                    <p class="text-3xl font-black text-slate-800">{{ $totalUsers }}</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-green-600 text-xl"><i class="fa-solid fa-users"></i></div>
            </div>

            {{-- Card Đơn chờ --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Đơn chờ xử lý</p>
                    <p class="text-3xl font-black text-slate-800">{{ $pendingOrders ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 rounded-full flex items-center justify-center text-purple-600 text-xl"><i class="fa-solid fa-calendar-days"></i></div>
            </div>

            {{-- Card Doanh thu --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Tổng Doanh thu</p>
                    <p class="text-3xl font-black text-orange-600">{{ number_format($totalRevenue) }}đ</p>
                </div>
                <div class="w-12 h-12 bg-orange-50 rounded-full flex items-center justify-center text-orange-600 text-xl"><i class="fa-solid fa-sack-dollar"></i></div>
            </div>
        </div>

        {{-- 2. BIỂU ĐỒ (SỬA LỖI JS) --}}
        

        {{-- 3. BẢNG DANH SÁCH (SỬA LỖI PHP) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-slate-800">Lịch hẹn mới nhất</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold">
                        <tr>
                            <th class="px-6 py-4">Bệnh nhân</th>
                            <th class="px-6 py-4">Bác sĩ</th>
                            <th class="px-6 py-4">Ngày khám</th>
                            <th class="px-6 py-4">Giá tiền</th>
                            <th class="px-6 py-4">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($recentAppointments ?? [] as $app)
                        <tr class="hover:bg-slate-50 transition">
                            {{-- 🔥 FIX LỖI PHP: Dùng optional() để tránh lỗi nếu user bị null --}}
                            <td class="px-6 py-4 font-bold text-slate-700">
                                {{ optional($app->user)->name ?? 'Người dùng đã xóa' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ optional($app->doctor)->name ?? 'Bác sĩ đã xóa' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($app->appointment_date)->format('d/m/Y') }}
                                <span class="text-slate-400 text-xs ml-1">{{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-600">{{ number_format($app->price) }}đ</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    {{ $app->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                      ($app->status == 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700') }}">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                Chưa có lịch hẹn nào gần đây.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT VẼ BIỂU ĐỒ --}}

@endsection