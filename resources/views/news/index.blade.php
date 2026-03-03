@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4">Góc Sức Khỏe & Y Học</h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Cập nhật những kiến thức y khoa mới nhất, lời khuyên từ chuyên gia để chăm sóc sức khỏe cho bạn và gia đình.
            </p>
        </div>

        {{-- Danh sách bài viết (Grid) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden border border-slate-100 flex flex-col h-full group">
                {{-- Ảnh bìa --}}
                <a href="{{ route('news.show', $post->id) }}" class="block overflow-hidden h-48 relative">
                    <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : asset('storage/'.$post->image) }}" 
     alt="{{ $post->title }}" 
     class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black bg-opacity-10 group-hover:bg-opacity-0 transition"></div>
                </a>

                {{-- Nội dung --}}
                <div class="p-6 flex-1 flex flex-col">
                    <div class="text-xs font-bold text-blue-600 mb-2 uppercase tracking-wide">
                        <i class="fa-regular fa-calendar mr-1"></i> {{ $post->created_at->format('d/m/Y') }}
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-800 mb-3 line-clamp-2 hover:text-blue-600 transition">
                        <a href="{{ route('news.show', $post->id) }}">{{ $post->title }}</a>
                    </h3>
                    
                    <p class="text-slate-500 text-sm mb-4 line-clamp-3 flex-1">
                        {{ $post->excerpt }}
                    </p>
                    
                    <a href="{{ route('news.show', $post->id) }}" class="inline-flex items-center text-blue-600 font-bold hover:underline mt-auto">
                        Đọc tiếp <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Phân trang --}}
        <div class="mt-12">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection