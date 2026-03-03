@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Chỉnh sửa bài viết</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label class="font-weight-bold">Tiêu đề bài viết</label>
                    <input type="text" name="title" class="form-control" required value="{{ $post->title }}">
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Tóm tắt ngắn</label>
                    <textarea name="excerpt" class="form-control" rows="3">{{ $post->excerpt }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Nội dung chi tiết</label>
                    <textarea name="content" class="form-control" rows="10" required>{{ $post->content }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Ảnh bìa hiện tại</label><br>
                    @if($post->image)
                        <img src="{{ asset('storage/'.$post->image) }}" width="150" class="mb-2 rounded border">
                    @endif
                    <input type="file" name="image" class="form-control-file">
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
@endsection