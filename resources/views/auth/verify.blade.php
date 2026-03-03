@extends('layouts.app') 

@section('content')
<div class="container" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-envelope-open-text me-2"></i> Xác minh địa chỉ Email</h4>
                </div>

                <div class="card-body p-5 text-center">
                    @if (session('resent'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-1"></i> Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <p class="card-text fs-5 mb-4">
                    Trước khi bắt đầu, vui lòng kiểm tra email của bạn để xác thực tài khoản.
                    </p>
                    
                    <div class="alert alert-warning d-inline-block text-start mb-4">
                        <small><i class="fas fa-info-circle"></i> Nếu không thấy email trong Hộp thư đến, vui lòng kiểm tra cả mục <strong>Spam (Thư rác)</strong>.</small>
                    </div>

                    <p class="mb-3">Nếu bạn vẫn chưa nhận được email, chúng tôi có thể gửi lại:</p>
                    
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary fw-bold px-4 py-2">
                            <i class="fas fa-paper-plane me-1"></i> Gửi lại email xác minh
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    console.log("Đang theo dõi trạng thái xác thực...");
    
    // Cứ 2 giây kiểm tra một lần
    setInterval(function() {
        // Thêm ?t=... để tránh trình duyệt cache kết quả cũ
        fetch('{{ route("check.verify.status") }}?t=' + new Date().getTime())
            .then(response => {
                if (!response.ok) throw new Error("Mạng lỗi hoặc chưa đăng nhập");
                return response.json();
            })
            .then(data => {
                // Nếu Server báo đã xác thực xong (true)
                if (data.verified) {
                    console.log("Đã xác thực! Đang chuyển hướng...");
                    // Chuyển thẳng vào Dashboard
                    window.location.href = '{{ route("dashboard") }}';
                }
            })
            .catch(error => console.error('Checking...', error));
    }, 2000); 
</script>
@endsection