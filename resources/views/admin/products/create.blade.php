@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Nhập thuốc mới vào kho</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label">Tên thuốc / Sản phẩm <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Đơn vị tính (Hộp/Vỉ/Chai) <span class="text-danger">*</span></label>
                    <input type="text" name="unit" class="form-control" value="Hộp" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh sản phẩm</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả / Công dụng</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection
