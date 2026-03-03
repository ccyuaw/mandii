@extends('layouts.admin') {{-- Đảm bảo tên layout đúng với file admin.blade.php của bạn --}}

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Quản lý Lịch Tư Vấn</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách lịch hẹn mới nhất</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Bệnh nhân</th>
                            <th>Bác sĩ phụ trách</th>
                            <th>Thời gian hẹn</th>
                            <th>Triệu chứng</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $app)
                        <tr>
                            <td>#{{ $app->id }}</td>
                            
                            {{-- Thông tin bệnh nhân --}}
                            <td class="fw-bold">{{ $app->user->name ?? 'User đã xóa' }}</td>
                            
                            {{-- Thông tin bác sĩ --}}
                            <td>
                                @if($app->doctor)
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $app->doctor->image) }}" class="rounded-circle mr-2" width="30" height="30" style="object-fit: cover;">
                                        <span>{{ $app->doctor->name }}</span>
                                    </div>
                                @else
                                    <span class="text-danger">Bác sĩ đã xóa</span>
                                @endif
                            </td>

                            {{-- Thời gian (Format lại cho đẹp) --}}
                            <td>
                                <div class="text-primary fw-bold">
                                    {{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i') }}
                                </div>
                                <div class="small text-muted">
                                    {{ \Carbon\Carbon::parse($app->appointment_time)->format('d/m/Y') }}
                                </div>
                            </td>

                            {{-- Triệu chứng (Cột symptoms mới thêm) --}}
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $app->symptoms }}">
                                    {{ $app->symptoms ?? 'Không có mô tả' }}
                                </span>
                            </td>

                            {{-- Trạng thái --}}
                            <td>
                                @if($app->status == 'pending')
                                    <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                @elseif($app->status == 'confirmed' || $app->status == 'accepted')
                                    <span class="badge bg-success">Đã duyệt</span>
                                @elseif($app->status == 'cancelled')
                                    <span class="badge bg-danger">Đã hủy</span>
                                @else
                                    <span class="badge bg-secondary">Hoàn thành</span>
                                @endif
                            </td>

                            {{-- Nút hành động --}}
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    {{-- Nút Chat: Hiện khi đã được duyệt (confirmed/accepted) --}}
                                    @if($app->status == 'confirmed' || $app->status == 'accepted')
                                        <a href="{{ route('admin.chat.show', $app->id) }}" class="btn btn-primary btn-sm me-1" title="Chat với bệnh nhân">
                                            <i class="fas fa-comments"></i> Chat
                                        </a>
                                    @endif

                                    @if($app->status == 'pending')
                                        {{-- Nút Duyệt --}}
                                        <form action="{{ route('admin.appointments.update', $app->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-success btn-sm me-1" title="Duyệt lịch">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        {{-- Nút Hủy --}}
                                        <form action="{{ route('admin.appointments.update', $app->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn hủy lịch này?');">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-danger btn-sm" title="Từ chối">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Chưa có lịch đặt nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Phân trang --}}
            <div class="mt-3">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection