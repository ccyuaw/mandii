<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class PharmacyController extends Controller
{
    public function index(Request $request)
    {
        // 1. Khởi tạo truy vấn
        $query = Product::with('category'); // Load kèm danh mục để hiển thị tên

        // 2. Nếu trên URL có ?category=1 thì lọc theo ID đó
        if ($request->has('category') && $request->category != null) {
            $query->where('category_id', $request->category);
        }

        // 3. Lấy dữ liệu (12 thuốc mỗi trang)
        $products = $query->latest()->paginate(12);

        // 4. Lấy danh sách danh mục để hiển thị ở Sidebar
        $categories = Category::all();

        // 5. Trả về View mà chúng ta vừa tạo ở Bước 1
        return view('pharmacy.index', compact('products', 'categories'));
    }
    public function show($id)
    {
        // 1. Lấy sản phẩm theo ID, kèm theo Category và Reviews (để hiển thị đánh giá)
        // 'reviews.user' giúp lấy luôn tên người bình luận để đỡ query nhiều lần
        $product = Product::with(['category', 'reviews.user'])->findOrFail($id);

        // 2. Lấy sản phẩm liên quan (cùng danh mục) - Gợi ý mua thêm
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id) // Trừ chính nó ra
            ->take(4) // Lấy 4 sản phẩm
            ->get();

        return view('pharmacy.show', compact('product', 'relatedProducts'));
    }
}