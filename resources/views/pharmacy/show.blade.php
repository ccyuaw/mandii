@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- Breadcrumb (Đường dẫn) --}}
        <nav class="flex text-sm text-slate-500 mb-6">
            <a href="{{ route('pharmacy.index') }}" class="hover:text-blue-600">Trang chủ</a>
            <span class="mx-2">/</span>
            <a href="{{ route('pharmacy.index', ['category' => $product->category_id]) }}" class="hover:text-blue-600">{{ $product->category->name }}</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800 font-medium">{{ $product->name }}</span>
        </nav>

        {{-- 1. THÔNG TIN SẢN PHẨM --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 mb-8">
            <div class="flex flex-col md:flex-row gap-10">
                
                {{-- Ảnh sản phẩm --}}
                <div class="w-full md:w-2/5">
                    <div class="aspect-square bg-white border border-slate-100 rounded-xl flex items-center justify-center p-4 relative overflow-hidden group">
                        <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/400' }}" 
                             class="object-contain w-full h-full transition duration-500 group-hover:scale-105" 
                             alt="{{ $product->name }}">
                        <span class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">-10%</span>
                    </div>
                </div>

                {{-- Thông tin chi tiết --}}
                <div class="w-full md:w-3/5">
                    <span class="inline-block bg-blue-100 text-blue-600 text-xs font-bold px-2 py-1 rounded mb-2 uppercase tracking-wide">
                        {{ $product->category->name }}
                    </span>
                    <h1 class="text-3xl font-bold text-slate-800 mb-2">{{ $product->name }}</h1>
                    
                    {{-- Rating Star nhỏ --}}
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex text-yellow-400 text-sm">
                            @php $avgRating = $product->reviews->avg('rating') ?? 0; @endphp
                            @for($i=1; $i<=5; $i++)
                                <i class="fa-{{ $i <= round($avgRating) ? 'solid' : 'regular' }} fa-star"></i>
                            @endfor
                        </div>
                        <span class="text-sm text-slate-500">({{ $product->reviews->count() }} đánh giá)</span>
                    </div>

                    <div class="text-4xl font-black text-blue-600 mb-2">
                        {{ number_format($product->price) }}đ
                        <span class="text-lg font-normal text-slate-400 line-through ml-2">{{ number_format($product->price * 1.1) }}đ</span>
                    </div>
                    
                    <p class="text-slate-600 mb-6 leading-relaxed">
                        {{ $product->description ?? 'Sản phẩm chính hãng, chất lượng cao, được dược sĩ khuyên dùng.' }}
                    </p>

                    <div class="border-t border-b border-slate-100 py-4 mb-6">
                        <ul class="space-y-2 text-sm text-slate-700">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-green-500"></i> Còn hàng</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-shield-halved text-blue-500"></i> Cam kết chính hãng 100%</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-truck-fast text-orange-500"></i> Giao hàng siêu tốc 2H</li>
                        </ul>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('cart.add', $product->id) }}" class="flex-1 bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ hàng
                        </a>
                        <a href="#" class="w-14 h-14 border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-red-500 hover:border-red-500 transition">
                            <i class="fa-solid fa-heart"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. SẢN PHẨM LIÊN QUAN --}}
        @if($relatedProducts->count() > 0)
        <div class="mb-10">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Sản phẩm liên quan</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($relatedProducts as $related)
                <div class="bg-white p-4 rounded-xl border border-slate-100 hover:shadow-lg transition">
                    <a href="{{ route('pharmacy.show', $related->id) }}" class="block aspect-square mb-2">
                        <img src="{{ $related->image ? asset($related->image) : 'https://via.placeholder.com/150' }}" class="w-full h-full object-contain">
                    </a>
                    <h4 class="font-bold text-sm mb-1 truncate">{{ $related->name }}</h4>
                    <span class="text-blue-600 font-bold">{{ number_format($related->price) }}đ</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- 3. PHẦN ĐÁNH GIÁ (ĐÃ TÍCH HỢP LOGIC BƯỚC TRƯỚC) --}}
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-slate-100" id="reviews-section">
            <h3 class="text-2xl font-bold mb-6 text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-comments text-blue-600"></i> Đánh giá từ khách hàng
            </h3>

            {{-- Thông báo lỗi/thành công khi đánh giá --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Cột trái: Danh sách comment --}}
                <div class="md:col-span-2 space-y-6">
                    @forelse($product->reviews as $review)
                        <div class="border-b border-slate-100 pb-4 last:border-0">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-lg">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-800 block">{{ $review->user->name }}</span>
                                        <div class="text-yellow-400 text-xs">
                                            @for($i=1; $i<=5; $i++)
                                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs text-slate-400">{{ $review->created_at->format('d/m/Y') }}</span>
                            </div>
                            <p class="text-slate-600 pl-14">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-slate-400">Chưa có đánh giá nào cho sản phẩm này.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Cột phải: Form viết đánh giá --}}
                <div>
                    @auth
                        <div class="bg-slate-50 p-6 rounded-xl border border-slate-100">
                            <h4 class="font-bold text-lg mb-4 text-slate-800">Viết đánh giá của bạn</h4>
                            <form action="{{ route('review.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1 text-slate-600">Bạn chấm mấy sao?</label>
                                    <div class="flex gap-2 flex-row-reverse justify-end rating-stars">
                                        {{-- CSS đảo ngược để hover sao hoạt động đúng logic từ trái qua phải --}}
                                        <input type="radio" name="rating" id="star5" value="5" class="hidden peer/5"><label for="star5" class="cursor-pointer text-slate-300 peer-checked/5:text-yellow-400 hover:text-yellow-400 text-2xl"><i class="fa-solid fa-star"></i></label>
                                        <input type="radio" name="rating" id="star4" value="4" class="hidden peer/4"><label for="star4" class="cursor-pointer text-slate-300 peer-checked/4:text-yellow-400 hover:text-yellow-400 text-2xl"><i class="fa-solid fa-star"></i></label>
                                        <input type="radio" name="rating" id="star3" value="3" class="hidden peer/3"><label for="star3" class="cursor-pointer text-slate-300 peer-checked/3:text-yellow-400 hover:text-yellow-400 text-2xl"><i class="fa-solid fa-star"></i></label>
                                        <input type="radio" name="rating" id="star2" value="2" class="hidden peer/2"><label for="star2" class="cursor-pointer text-slate-300 peer-checked/2:text-yellow-400 hover:text-yellow-400 text-2xl"><i class="fa-solid fa-star"></i></label>
                                        <input type="radio" name="rating" id="star1" value="1" class="hidden peer/1"><label for="star1" class="cursor-pointer text-slate-300 peer-checked/1:text-yellow-400 hover:text-yellow-400 text-2xl"><i class="fa-solid fa-star"></i></label>
                                    </div>
                                    {{-- Script nhỏ để highlight sao khi chọn (CSS peer của tailwind đã xử lý phần lớn) --}}
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1 text-slate-600">Nhận xét:</label>
                                    <textarea name="comment" rows="3" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Sản phẩm dùng tốt không?..." required></textarea>
                                </div>

                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                                    Gửi đánh giá
                                </button>
                                <p class="text-xs text-slate-400 mt-2 text-center">* Chỉ khách hàng đã mua sản phẩm này mới được đánh giá.</p>
                            </form>
                        </div>
                    @else
                        <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-200 text-center">
                            <i class="fa-solid fa-lock text-yellow-600 text-2xl mb-2"></i>
                            <p class="text-yellow-800 mb-2">Bạn cần đăng nhập để viết đánh giá.</p>
                            <a href="{{ route('login') }}" class="inline-block bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-yellow-700">Đăng nhập ngay</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS hack nhỏ để giữ sao sáng khi đã chọn */
    .rating-stars:hover label { color: #facc15; } /* Hover vào cha thì sáng hết */
    .rating-stars label:hover ~ label { color: #facc15; } /* Sáng các sao bên trái sao đang hover */
    .rating-stars input:checked ~ label { color: #facc15; } /* Sáng các sao bên trái sao đã check */
</style>
@endsection