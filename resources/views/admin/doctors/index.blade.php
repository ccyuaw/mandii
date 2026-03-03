@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Bác sĩ</h6>
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Thêm mới
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="30%">Bác sĩ</th>
                        <th width="20%">Chuyên khoa</th>
                        <th width="15%">Giá tư vấn</th>
                        <th width="15%">Thông tin thêm</th>
                        <th width="15%" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doctor)
                    <tr>
                        <td>#{{ $doctor->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $doctor->image ? asset('storage/'.$doctor->image) : 'https://ui-avatars.com/api/?name='.$doctor->name }}" 
                                     class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;">
                                <div>
                                    <div class="fw-bold text-primary">{{ $doctor->name }}</div>
                                    <small class="text-muted">{{ $doctor->hospital }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{-- SỬA LỖI JSON Ở ĐÂY: Thêm ->name --}}
                            <span class="badge bg-info text-dark">
                                {{ $doctor->specialty->name ?? 'Chưa phân loại' }}
                            </span>
                        </td>
                        <td class="fw-bold text-danger">
                            {{ number_format($doctor->price) }}đ
                        </td>
                        <td>
                            <small class="d-block"><i class="fas fa-briefcase text-muted"></i> {{ $doctor->experience_years }} năm KN</small>
                            <small class="d-block"><i class="fas fa-star text-warning"></i> {{ $doctor->rating }}/5.0</small>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-info btn-sm text-white" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bác sĩ này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{-- Phân trang --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $doctors->links() }}
            </div>
        </div>
    </div>
</div>
@endsection