@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- Header & Tìm kiếm --}}
        <div class="mb-10">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Danh sách bác sĩ</h1>
            
            {{-- Thanh tìm kiếm đẹp --}}
            <form action="{{ route('doctors.index') }}" method="GET" class="relative max-w-3xl">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Tìm bác sĩ, chuyên khoa..." 
                       class="w-full pl-5 pr-32 py-4 rounded-xl border border-slate-200 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
                <button type="submit" class="absolute right-2 top-2 bottom-2 bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-lg font-bold transition">
                    Tìm kiếm
                </button>
            </form>
        </div>

        {{-- GRID BÁC SĨ (Style Card mới) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($doctors as $doctor)
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm hover:shadow-lg transition duration-300 p-6 flex flex-col items-center text-center group">
                
                {{-- Avatar --}}
                <div class="relative mb-4">
                    <img src="{{ $doctor->image ? asset('storage/'.$doctor->image) : 'https://ui-avatars.com/api/?name=' . $doctor->name . '&background=random' }}" 
                         class="w-28 h-28 rounded-full object-cover border-4 border-slate-50 shadow-sm group-hover:scale-105 transition duration-300">
                </div>

                {{-- Tên & Chuyên khoa --}}
                <h3 class="font-bold text-lg text-slate-800 mb-1 group-hover:text-blue-600 transition">
                    {{ $doctor->name }}
                </h3>
                
                <div class="flex items-center gap-1 text-green-500 text-sm font-semibold mb-3">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Trực tuyến
                </div>

                <div class="text-sm text-slate-500 mb-1">
                    <i class="fa-solid fa-stethoscope text-blue-500 mr-1"></i> {{ $doctor->specialty->name ?? 'Đa khoa' }}
                </div>
                <div class="text-sm text-slate-500 mb-6 truncate w-full px-4">
                    <i class="fa-solid fa-hospital text-blue-500 mr-1"></i> {{ $doctor->hospital ?? 'Bệnh viện Đa khoa' }}
                </div>

                {{-- Thống kê 3 cột (Giống mẫu) --}}
                <div class="w-full grid grid-cols-3 gap-2 border-t border-slate-100 pt-4 mb-6">
                    <div>
                        <div class="text-xs text-slate-400 mb-1">Đánh giá</div>
                        <div class="font-bold text-slate-700 text-sm">
                            <i class="fa-solid fa-star text-yellow-400"></i> {{ $doctor->rating ?? 5.0 }}
                        </div>
                    </div>
                    <div class="border-l border-slate-100">
                        <div class="text-xs text-slate-400 mb-1">Lượt tư vấn</div>
                        <div class="font-bold text-slate-700 text-sm">
                            <i class="fa-solid fa-user-check text-blue-500"></i> {{ $doctor->consultation_count ?? 100 }}+
                        </div>
                    </div>
                    <div class="border-l border-slate-100">
                        <div class="text-xs text-slate-400 mb-1">Kinh nghiệm</div>
                        <div class="font-bold text-slate-700 text-sm">
                            <i class="fa-solid fa-briefcase text-blue-500"></i> {{ $doctor->experience_years ?? 5 }} năm
                        </div>
                    </div>
                </div>

                {{-- Nút hành động --}}
                <a href="{{ route('doctors.show', $doctor->id) }}" class="w-full py-3 rounded-lg bg-blue-50 text-blue-600 font-bold hover:bg-blue-600 hover:text-white transition">
                    Đặt tư vấn
                </a>
            </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection