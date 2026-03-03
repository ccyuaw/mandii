<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Danh sách thuốc
    public function index() {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // Form thêm mới
    public function create() {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Lưu thuốc mới
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
            'description' => 'nullable',
            'unit' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Thêm thuốc thành công!');
    }
    
    // Xóa thuốc
    public function destroy($id) {
        $product = Product::findOrFail($id);
        if($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();
        return back()->with('success', 'Đã xóa sản phẩm');
    }
    public function edit($id)
{
    // 1. Tìm sản phẩm cần sửa
    $product = Product::findOrFail($id);
    
    // 2. Lấy danh sách danh mục (để hiển thị trong dropdown)
    $categories = Category::all();

    // 3. Trả về view sửa
    return view('admin.products.edit', compact('product', 'categories'));
}

public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // 1. Validate dữ liệu
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'category_id' => 'required',
        'unit' => 'required',
    ]);

    // 2. Chuẩn bị dữ liệu update
    $data = $request->all();

    // 3. Xử lý ảnh (Nếu người dùng có tải ảnh mới lên)
    if ($request->hasFile('image')) {
        // Lưu ảnh mới vào thư mục public/images/products
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/products'), $filename);
        
        // Cập nhật đường dẫn vào database
        $data['image'] = '/images/products/' . $filename;
    } else {
        // Nếu không chọn ảnh mới thì giữ nguyên ảnh cũ
        $data['image'] = $product->image; 
    }

    // 4. Cập nhật vào DB
    $product->update($data);

    return redirect()->route('admin.products.index')->with('success', 'Cập nhật thuốc thành công!');
}
}