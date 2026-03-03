@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kho Thuốc & Sản Phẩm</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nhập thuốc mới</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá bán</th>
                    <th>Đơn vị</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $product->image) }}" width="50" height="50" class="object-fit-cover">
                    </td>
                    <td class="fw-bold">{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td class="text-primary fw-bold">{{ number_format($product->price) }}đ</td>
                    <td>{{ $product->unit }}</td>
                    <td>
                        <div class="d-flex gap-2">
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
            <i class="fa fa-edit"></i> Sửa
        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Xóa thuốc này?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
    </div>
</div>
@endsection