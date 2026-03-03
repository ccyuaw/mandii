@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- 1. HIỂN THỊ THÔNG BÁO THÀNH CÔNG --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</span>
            </div>
        @endif

        {{-- Banner --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-8 mb-8 text-white flex justify-between items-center shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl font-black mb-2">Nhà thuốc Online MANDI</h1>
                <p class="text-blue-100 text-lg">Thuốc chính hãng - Tư vấn tận tâm - Giao siêu tốc 2H</p>
            </div>
            <i class="fa-solid fa-pills text-8xl opacity-20 absolute right-10 bottom-[-20px]"></i>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            {{-- SIDEBAR DANH MỤC --}}
            <div class="w-full md:w-1/4">
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 sticky top-24">
                    <h3 class="font-bold text-lg mb-4 text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-list text-blue-600"></i> Danh mục
                    </h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('pharmacy.index') }}" 
                               class="block px-4 py-3 rounded-lg transition font-medium {{ !request('category') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-blue-50 text-slate-600' }}">
                                Tất cả sản phẩm
                            </a>
                        </li>
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('pharmacy.index', ['category' => $cat->id]) }}" 
                               class="block px-4 py-3 rounded-lg transition font-medium {{ request('category') == $cat->id ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-blue-50 text-slate-600' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- DANH SÁCH SẢN PHẨM --}}
            <div class="w-full md:w-3/4">
                <div class="mb-6 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-slate-800">
                        @if(request('category'))
                            Đang xem: <span class="text-blue-600">{{ $categories->find(request('category'))->name ?? 'Danh mục' }}</span>
                        @else
                            Tất cả sản phẩm
                        @endif
                    </h2>
                    <span class="text-sm text-slate-500">{{ $products->total() }} sản phẩm</span>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($products as $product)
                        <div class="bg-white rounded-xl border border-slate-100 shadow-sm hover:shadow-lg transition group overflow-hidden flex flex-col h-full relative">
                            
                            {{-- 2. LIÊN KẾT ẢNH ĐẾN TRANG CHI TIẾT --}}
                            <a href="{{ route('pharmacy.show', $product->id) }}" class="aspect-square p-4 flex items-center justify-center bg-white relative block">
                                <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/150' }}" 
                                     class="object-contain w-full h-full group-hover:scale-110 transition duration-300">
                                <span class="absolute top-2 left-2 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded">-10%</span>
                            </a>

                            <div class="p-4 flex flex-col flex-grow">
                                <div class="mb-1">
                                    <span class="text-[10px] bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                                
                                {{-- 3. LIÊN KẾT TÊN SẢN PHẨM ĐẾN TRANG CHI TIẾT --}}
                                <h3 class="font-bold text-slate-800 text-sm mb-2 line-clamp-2 h-10 group-hover:text-blue-600 transition">
                                    <a href="{{ route('pharmacy.show', $product->id) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                
                                <div class="mt-auto pt-3 border-t border-slate-50 flex items-end justify-between">
                                    <div>
                                        <span class="block text-lg font-black text-blue-600">{{ number_format($product->price) }}đ</span>
                                        <span class="text-xs text-slate-400">/ {{ $product->unit }}</span>
                                    </div>
                                    
                                    {{-- Nút thêm vào giỏ hàng (giữ nguyên) --}}
                                    <a href="{{ route('cart.add', $product->id) }}" 
                                       class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition shadow-sm"
                                       title="Thêm vào giỏ">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $products->withQueryString()->links() }} 
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-xl border border-slate-100 shadow-sm">
                        <i class="fa-solid fa-box-open text-6xl text-slate-200 mb-4"></i>
                        <p class="text-slate-500">Chưa có sản phẩm nào trong danh mục này.</p>
                        <a href="{{ route('pharmacy.index') }}" class="text-blue-600 font-bold hover:underline mt-2 inline-block">Xem tất cả sản phẩm</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection