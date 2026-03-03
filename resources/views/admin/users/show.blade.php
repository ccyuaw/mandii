@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-6">

    {{-- Header & Nút quay lại --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            {{-- Đổi tiêu đề dựa theo quyền --}}
            {{ $user->role == 'admin' ? 'Thông tin Quản Trị Viên' : 'Hồ sơ Bệnh nhân' }}: {{ $user->name }}
        </h1>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm font-bold transition">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        {{-- CỘT TRÁI: THÔNG TIN CƠ BẢN (Ai cũng có) --}}
        <div class="lg:col-span-4">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 font-bold text-slate-700">
                    Thông tin chung
                </div>
                <div class="p-6 text-center">
                    <img class="w-32 h-32 rounded-full object-cover mx-auto mb-4 border-4 border-slate-50 shadow-sm" 
                         src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.$user->name.'&background=random&size=150' }}">
                    
                    <h3 class="text-xl font-bold text-slate-800">{{ $user->name }}</h3>
                    <p class="text-slate-500 text-sm mb-4">{{ $user->email }}</p>
                    
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold 
                        {{ $user->role == 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                        {{ ucfirst($user->role) }}
                    </span>

                    <div class="mt-6 text-left space-y-3 border-t border-slate-100 pt-6">
                        <div class="flex items-start">
                            <i class="fas fa-phone text-slate-400 w-6 mt-1"></i>
                            <div>
                                <span class="block text-xs text-slate-400">Số điện thoại</span>
                                <span class="font-medium text-slate-700">{{ $user->phone ?? '---' }}</span>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-birthday-cake text-slate-400 w-6 mt-1"></i>
                            <div>
                                <span class="block text-xs text-slate-400">Ngày sinh</span>
                                <span class="font-medium text-slate-700">
                                    {{ $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('d/m/Y') : '---' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-venus-mars text-slate-400 w-6 mt-1"></i>
                            <div>
                                <span class="block text-xs text-slate-400">Giới tính</span>
                                <span class="font-medium text-slate-700">
                                    @if($user->gender == 'nam') Nam
                                    @elseif($user->gender == 'nu') Nữ
                                    @else ---
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-slate-400 w-6 mt-1"></i>
                            <div>
                                <span class="block text-xs text-slate-400">Địa chỉ</span>
                                <span class="font-medium text-slate-700">{{ $user->address ?? '---' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CỘT PHẢI: XỬ LÝ LOGIC HIỂN THỊ --}}
        <div class="lg:col-span-8">
            
            {{-- TRƯỜNG HỢP 1: NẾU LÀ ADMIN --}}
            @if($user->role == 'admin')
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 text-center h-full flex flex-col justify-center items-center">
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-user-shield text-3xl text-blue-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Tài khoản Quản Trị Viên</h3>
                    <p class="text-slate-500 mt-2 max-w-md">
                        Đây là tài khoản có quyền truy cập hệ thống quản trị. 
                        Tài khoản này không lưu trữ thông tin y tế cá nhân như bệnh nhân.
                    </p>
                    <div class="mt-6 text-sm text-slate-400">
                        Ngày tạo: {{ $user->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>

            {{-- TRƯỜNG HỢP 2: NẾU LÀ USER (BỆNH NHÂN) -> HIỆN FORM Y TẾ --}}
            @else
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 h-full">
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                        <span class="font-bold text-slate-700">
                            <i class="fas fa-file-medical text-red-500 mr-2"></i> Thông tin Y tế & Tiền sử bệnh
                        </span>
                    </div>
                    
                    <div class="p-6">
                        {{-- Tiền sử bệnh --}}
                        <div class="mb-8">
                            @if($user->medical_history)
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                                    <h5 class="font-bold text-yellow-800 mb-1">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Lưu ý quan trọng:
                                    </h5>
                                    <p class="text-slate-700 leading-relaxed">
                                        {!! nl2br(e($user->medical_history)) !!}
                                    </p>
                                </div>
                            @else
                                <div class="text-center py-8 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                                    <i class="fas fa-clipboard-check text-4xl text-slate-300 mb-3"></i>
                                    <p class="text-slate-500">Bệnh nhân chưa cập nhật tiền sử bệnh.</p>
                                </div>
                            @endif
                        </div>

                        <hr class="border-slate-100 my-6">
                        
                        {{-- Lịch sử khám --}}
                        
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection