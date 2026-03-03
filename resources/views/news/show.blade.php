@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen pb-16">
    {{-- Banner ảnh bìa (Nền mờ) --}}
    <div class="relative h-64 md:h-80 bg-slate-900 overflow-hidden">
        <img src="{{ $post->image ? asset('storage/'.$post->image) : 'https://source.unsplash.com/random/1200x800/?medical,hospital&sig='.$post->id }}" 
             class="w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 w-full p-6 md:p-10 text-white max-w-5xl mx-auto">
            <a href="{{ route('news.index') }}" class="inline-flex items-center text-slate-300 hover:text-white mb-4 text-sm font-bold transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại góc sức khỏe
            </a>
            <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-4 shadow-sm">
                {{ $post->title }}
            </h1>
            <div class="flex items-center text-sm md:text-base text-slate-300 gap-6">
                <span><i class="fa-regular fa-user mr-2"></i> {{ $post->user->name ?? 'Ban biên tập' }}</span>
                <span><i class="fa-regular fa-clock mr-2"></i> {{ $post->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10 flex flex-col lg:flex-row gap-10">
        
        {{-- NỘI DUNG CHÍNH --}}
        <div class="lg:w-3/4 bg-white rounded-t-xl p-6 md:p-0">
            <article class="prose prose-lg prose-blue max-w-none text-slate-700 leading-relaxed">
                <p class="font-bold text-xl text-slate-900 mb-6 italic border-l-4 border-blue-500 pl-4">
                    {{ $post->excerpt }}
                </p>
                
                {{-- Hiển thị nội dung HTML --}}
                {!! $post->content !!}
            </article>

            {{-- Chia sẻ / Tags --}}
            <div class="border-t border-slate-100 mt-10 pt-6 flex justify-between items-center">
                <div class="font-bold text-slate-800">Chia sẻ bài viết:</div>
                <div class="flex gap-2">
                    <button class="w-10 h-10 rounded-full bg-blue-600 text-white hover:bg-blue-700"><i class="fa-brands fa-facebook-f"></i></button>
                    <button class="w-10 h-10 rounded-full bg-sky-400 text-white hover:bg-sky-500"><i class="fa-brands fa-twitter"></i></button>
                    <button class="w-10 h-10 rounded-full bg-red-500 text-white hover:bg-red-600"><i class="fa-solid fa-envelope"></i></button>
                </div>
            </div>
        </div>

        {{-- SIDEBAR: BÀI VIẾT LIÊN QUAN --}}
        <div class="lg:w-1/4 space-y-8 mt-8 lg:mt-0">
            <div class="bg-slate-50 rounded-xl p-6 border border-slate-100 sticky top-4">
                <h3 class="font-bold text-slate-800 text-lg mb-4 border-b pb-2">Bài viết khác</h3>
                <div class="space-y-4">
                    @foreach($related_posts as $related)
                    <div class="flex gap-3 group">
                        <a href="{{ route('news.show', $related->id) }}" class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden">
                            <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : asset('storage/'.$post->image) }}" 
     class="w-full h-full object-cover opacity-60">
                        </a>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 line-clamp-2 group-hover:text-blue-600 transition">
                                <a href="{{ route('news.show', $related->id) }}">{{ $related->title }}</a>
                            </h4>
                            <span class="text-xs text-slate-400 mt-1 block">{{ $related->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
@endsection