@extends('layouts.admin') {{-- ⚠️ LƯU Ý: Đổi tên layout admin của bạn (ví dụ: layouts.admin, admin.layout...) --}}

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <h1 class="h3 text-gray-800"><i class="fas fa-star text-warning me-2"></i> Quản lý Đánh giá</h1>
    </div>

    {{-- Thông báo thành công --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách bình luận sản phẩm</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 15%">Khách hàng</th>
                            <th style="width: 20%">Sản phẩm</th>
                            <th style="width: 10%" class="text-center">Đánh giá</th>
                            <th>Nội dung bình luận</th>
                            <th style="width: 10%">Ngày gửi</th>
                            <th style="width: 5%" class="text-center">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>
                                <div class="fw-bold">{{ $review->user->name ?? 'User đã xóa' }}</div>
                                <small class="text-muted">{{ $review->user->email ?? '' }}</small>
                            </td>
                            <td>
                                <a href="{{ route('pharmacy.show', $review->product_id) }}" target="_blank" class="text-decoration-none">
                                    {{ $review->product->name ?? 'Sản phẩm đã xóa' }} <i class="fas fa-external-link-alt small"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning text-dark">
                                    {{ $review->rating }} <i class="fas fa-star small"></i>
                                </span>
                            </td>
                            <td>
                                {{ $review->comment }}
                            </td>
                            <td>
                                <small>{{ $review->created_at->format('d/m/Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $review->created_at->format('H:i') }}</small>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa bình luận này? Hành động này không thể hoàn tác.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa bình luận">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-comment-slash fa-2x mb-3 d-block"></i>
                                Chưa có đánh giá nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Phân trang --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $reviews->links() }} 
                {{-- Nếu dùng Bootstrap 4/5 thì Laravel tự style đẹp, nếu không hiện đẹp hãy báo mình chỉnh lại --}}
            </div>
        </div>
    </div>
</div>
@endsection