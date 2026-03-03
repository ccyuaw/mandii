@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Viết bài mới</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label class="font-weight-bold">Tiêu đề bài viết</label>
                    <input type="text" name="title" class="form-control" required placeholder="Nhập tiêu đề...">
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Tóm tắt ngắn (Excerpt)</label>
                    <textarea name="excerpt" class="form-control" rows="3" placeholder="Mô tả ngắn gọn nội dung..."></textarea>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Nội dung chi tiết</label>
                    {{-- Sau này có thể gắn CKEditor vào đây --}}
                    <textarea name="content" class="form-control" rows="10" required></textarea>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Ảnh bìa</label>
                    <input type="file" name="image" class="form-control-file">
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Đăng bài</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
@endsection