@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4" style="max-width: 1000px; margin: 0 auto;">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Thêm Bác sĩ Mới</h6>
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary btn-sm">Quay lại</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.doctors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Hàng 1: Thông tin cơ bản --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Họ và Tên <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="VD: BS.CKI Nguyễn Văn A" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Chuyên khoa <span class="text-danger">*</span></label>
                    <select name="specialty_id" class="form-select" required>
                        <option value="">-- Chọn chuyên khoa --</option>
                        @foreach($specialties as $specialty)
                            <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Hàng 2: Nơi công tác & Kinh nghiệm --}}
            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold">Bệnh viện / Nơi công tác <span class="text-danger">*</span></label>
                    <input type="text" name="hospital" class="form-control" placeholder="VD: Bệnh viện Bạch Mai" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Kinh nghiệm (Năm) <span class="text-danger">*</span></label>
                    <input type="number" name="experience_years" class="form-control" value="5" min="1" required>
                </div>
            </div>

            {{-- Hàng 3: Chi phí & Chỉ số ảo --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Giá khám (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" name="price" class="form-control" placeholder="VD: 200000" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Giá cũ (để gạch đi)</label>
                    <input type="number" name="old_price" class="form-control" placeholder="VD: 300000">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Đánh giá (Sao)</label>
                    <input type="number" step="0.1" name="rating" class="form-control" value="5.0" max="5">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Số lượt tư vấn (Fake)</label>
                    <input type="number" name="consultation_count" class="form-control" value="100">
                </div>
            </div>

            {{-- Hàng 4: Ảnh đại diện --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Ảnh đại diện</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            {{-- Hàng 5: Giới thiệu ngắn --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Giới thiệu ngắn (Bio)</label>
                <textarea name="bio" class="form-control" rows="3" placeholder="Câu slogan hoặc mô tả ngắn gọn về bác sĩ..."></textarea>
            </div>

            {{-- Hàng 6: Chi tiết (HTML) --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Quá trình công tác</label>
                    <textarea name="work_history" class="form-control" rows="5" placeholder="VD: 2010-2015: Bệnh viện A..."></textarea>
                    <small class="text-muted">Nhập mỗi dòng một mốc thời gian.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Học vấn</label>
                    <textarea name="education" class="form-control" rows="5" placeholder="VD: 2010: Tốt nghiệp ĐH Y Hà Nội..."></textarea>
                    <small class="text-muted">Nhập mỗi dòng một bằng cấp.</small>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Lưu thông tin Bác sĩ</button>
        </form>
    </div>
</div>
@endsection