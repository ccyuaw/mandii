@extends('layouts.admin') {{-- Thay bằng layout admin của bạn --}}

@section('content')
<div class="container-fluid">
    <h2>Chỉnh sửa thuốc: {{ $product->name }}</h2>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Bắt buộc phải có dòng này để Laravel hiểu là Update --}}

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Tên thuốc</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Danh mục</label>
                <select name="category_id" class="form-control">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Giá bán (VNĐ)</label>
                <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Đơn vị tính</label>
                <input type="text" name="unit" class="form-control" value="{{ $product->unit }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Số lượng kho</label>
                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
            </div>

            <div class="col-md-12 mb-3">
                <label>Mô tả / Công dụng</label>
                <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
            </div>

            <div class="col-md-12 mb-3">
                <label>Hình ảnh</label>
                <input type="file" name="image" class="form-control">
                <br>
                <img src="{{ $product->image }}" width="100" class="img-thumbnail">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection