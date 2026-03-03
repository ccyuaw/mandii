@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý Tin tức</h1>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Viết bài mới
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Tác giả</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($posts->count() > 0)
                            @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>
                                    @if($post->image)
                                        <img src="{{ asset('storage/'.$post->image) }}" width="50" style="border-radius: 4px">
                                    @else
                                        <span>Không có ảnh</span>
                                    @endif
                                </td>
                                <td>{{ $post->title }}</td>
                                <td>
                                    {{-- Dùng cú pháp ?? để tránh lỗi nếu user bị xóa --}}
                                    {{ $post->user->name ?? 'Admin ẩn danh' }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                    
                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Xóa nhé?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Chưa có bài viết nào.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            {{-- Phân trang --}}
            <div class="mt-3">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection