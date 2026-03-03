@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4">
        
        {{-- Breadcrumb --}}
        <div class="text-sm text-slate-500 mb-6 flex items-center gap-2">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Trang chủ</a> 
            <i class="fa-solid fa-chevron-right text-xs"></i> 
            <a href="{{ route('doctors.index') }}" class="hover:text-blue-600">Bác sĩ</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-slate-800 font-bold">{{ $doctor->name }}</span>
        </div>

        {{-- HEADER PROFILE (Phần trên cùng) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 mb-8">
            <div class="flex flex-col md:flex-row gap-8">
                
                {{-- Cột Trái: Ảnh & Thống kê box --}}
                <div class="w-full md:w-1/3 flex flex-col items-center">
                    <img src="{{ $doctor->image ? asset('storage/'.$doctor->image) : 'https://ui-avatars.com/api/?name=' . $doctor->name . '&background=random' }}" 
                         class="w-48 h-48 rounded-2xl object-cover shadow-lg mb-6">
                    
                    {{-- Box thống kê nhỏ --}}
                    <div class="w-full bg-slate-50 rounded-xl p-4 border border-slate-100 grid grid-cols-3 gap-2 text-center">
                        <div>
                            <div class="font-bold text-blue-600 text-lg">{{ $doctor->consultation_count ?? 500 }}+</div>
                            <div class="text-xs text-slate-500">Lượt tư vấn</div>
                        </div>
                        <div class="border-l border-slate-200">
                            <div class="font-bold text-blue-600 text-lg">{{ $doctor->experience_years ?? 5 }} năm</div>
                            <div class="text-xs text-slate-500">Kinh nghiệm</div>
                        </div>
                        <div class="border-l border-slate-200">
                            <div class="font-bold text-blue-600 text-lg">100%</div>
                            <div class="text-xs text-slate-500">Hài lòng</div>
                        </div>
                    </div>
                </div>

                {{-- Cột Phải: Thông tin & Giá --}}
                <div class="w-full md:w-2/3">
                    <div class="flex items-center gap-2 mb-2">
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-900">{{ $doctor->name }}</h1>
                        <span class="bg-green-100 text-green-600 text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-green-600 rounded-full animate-pulse"></span> Trực tuyến
                        </span>
                    </div>

                    <p class="text-blue-500 italic mb-4">"{{ $doctor->bio ?? 'Cùng san sẻ nỗi đau - Cùng bên nhau giành sự sống' }}"</p>

                    <div class="space-y-3 text-sm text-slate-700 mb-6">
                        <div class="flex">
                            <span class="w-32 text-slate-500">Chuyên khoa:</span>
                            <span class="font-semibold">{{ $doctor->specialty->name ?? 'Đa khoa' }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-32 text-slate-500">Nơi công tác:</span>
                            <span class="font-semibold">{{ $doctor->hospital ?? 'Bệnh viện Trung Ương' }}</span>
                        </div>
                    </div>

                    {{-- Phần Giá --}}
                    <div class="flex items-end gap-3 mb-2">
                        <span class="text-slate-500 mb-1">Chi phí tư vấn:</span>
                        @if($doctor->old_price)
                            <span class="text-slate-400 line-through text-lg">{{ number_format($doctor->old_price) }}đ</span>
                        @endif
                        <span class="text-3xl font-black text-blue-600">{{ number_format($doctor->price) }}đ</span>
                    </div>
                    <p class="text-xs text-slate-400 mb-6">Giảm 50K cho lần đầu tư vấn bác sĩ</p>

                    <div class="flex gap-4">
                        <a href="{{ route('booking.create', $doctor->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-3.5 rounded-xl font-bold text-lg shadow-lg shadow-blue-200 transition">
                            ĐẶT TƯ VẤN NGAY
                        </a>
                        <button class="w-14 h-14 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition">
                            <i class="fa-regular fa-heart text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- INFO TABS (Phần dưới) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Cột trái (Chi tiết) --}}
            <div class="md:col-span-2 space-y-8">
                
                {{-- Thông tin chi tiết --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4">
                        Thông tin chi tiết
                    </h3>
                    <div class="prose prose-sm prose-blue text-slate-600">
                        {!! $doctor->bio ?? '<p>Bác sĩ chưa cập nhật thông tin giới thiệu.</p>' !!}
                    </div>
                </div>

                {{-- Quá trình công tác --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4">
                        Quá trình công tác
                    </h3>
                    <ul class="space-y-3">
                        {{-- Data giả lập nếu chưa có --}}
                        <li class="flex gap-3">
                            <span class="font-bold text-slate-700 min-w-[100px]">2019 - Nay:</span>
                            <span class="text-slate-600">{{ $doctor->hospital }} - Khoa {{ $doctor->specialty->name }}</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="font-bold text-slate-700 min-w-[100px]">2015 - 2019:</span>
                            <span class="text-slate-600">Đại học Y Dược TP.HCM - Bác sĩ nội trú</span>
                        </li>
                    </ul>
                </div>

                {{-- Học vấn --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4">
                        Học vấn
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex gap-3">
                            <span class="font-bold text-slate-700 min-w-[100px]">2015:</span>
                            <span class="text-slate-600">Tốt nghiệp Bác sĩ Đa khoa - ĐH Y Dược</span>
                        </li>
                    </ul>
                </div>

            </div>

            {{-- Cột phải (Gợi ý) --}}
            <div>
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 sticky top-24">
                    <h3 class="font-bold text-slate-800 mb-4">Bác sĩ cùng chuyên khoa</h3>
                    <div class="space-y-4">
                        @foreach($relatedDoctors as $relDoc)
                        <a href="{{ route('doctors.show', $relDoc->id) }}" class="flex items-center gap-3 group">
                            <img src="{{ $relDoc->image ? asset('storage/'.$relDoc->image) : 'https://ui-avatars.com/api/?name=' . $relDoc->name }}" 
                                 class="w-12 h-12 rounded-full object-cover border border-slate-100">
                            <div>
                                <h4 class="font-bold text-sm text-slate-800 group-hover:text-blue-600 line-clamp-1">{{ $relDoc->name }}</h4>
                                <p class="text-xs text-slate-500">{{ number_format($relDoc->price) }}đ</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection