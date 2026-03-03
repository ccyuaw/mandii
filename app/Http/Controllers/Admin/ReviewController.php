<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // 1. Danh sách đánh giá
    public function index()
    {
        // Lấy danh sách đánh giá mới nhất, kèm thông tin User và Product để hiển thị
        // Phân trang 10 dòng/trang
        $reviews = Review::with(['user', 'product'])->latest()->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    // 2. Xóa đánh giá
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Đã xóa đánh giá thành công!');
    }
}