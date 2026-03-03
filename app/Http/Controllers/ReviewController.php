<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        // 1. KIỂM TRA ĐÃ MUA HÀNG CHƯA?
        // Logic: Tìm trong các đơn hàng đã thanh toán (hoặc đã giao) của user này xem có sản phẩm đó không
        $hasPurchased = Order::where('user_id', $user->id)
            ->where('payment_status', 'paid') // Hoặc status = 'completed' tùy logic của bạn
            ->whereHas('items', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })->exists();

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'Bạn cần mua và thanh toán sản phẩm này trước khi đánh giá.');
        }

        // 2. KIỂM TRA ĐÃ ĐÁNH GIÁ CHƯA? (Mỗi người 1 lần)
        $existingReview = Review::where('user_id', $user->id)
                                ->where('product_id', $productId)
                                ->exists();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        // 3. TẠO ĐÁNH GIÁ
        Review::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}