@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary btn-sm mb-3">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách
    </a>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-user-injured mr-2"></i>
                Chat với bệnh nhân: {{ $appointment->user->name }}
            </h6>
            <span class="badge badge-light text-primary">Lịch hẹn #{{ $appointment->id }}</span>
        </div>

        <div class="card-body">
            <div id="chat-box" style="height: 400px; overflow-y: auto; background-color: #f8f9fa; padding: 15px; border-radius: 5px; border: 1px solid #e3e6f0;">
                <div class="text-center text-muted mt-5">Đang tải tin nhắn...</div>
            </div>
        </div>

        <div class="card-footer">
            <form id="chat-form" class="d-flex gap-2">
                <input type="text" id="message-input" class="form-control" placeholder="Nhập câu trả lời của bác sĩ..." autocomplete="off">
                <button type="submit" class="btn btn-primary ml-2">
                    <i class="fas fa-paper-plane"></i> Gửi
                </button>
            </form>
        </div>
    </div>

</div>

{{-- SCRIPT XỬ LÝ CHAT (Giống bên User nhưng chỉnh lại CSS một chút cho hợp Admin) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const appointmentId = {{ $appointment->id }};
    const currentUserId = {{ Auth::id() }};
    const chatBox = document.getElementById('chat-box');

    // 1. Tải tin nhắn
    function fetchMessages() {
        $.get(`/appointment/${appointmentId}/messages`, function(messages) {
            let html = '';
            messages.forEach(msg => {
                let isMe = (msg.user_id == currentUserId);
                
                if (isMe) {
                    // Tin nhắn của ADMIN (Bên phải, màu xanh)
                    html += `
                        <div class="d-flex justify-content-end mb-2">
                            <div class="bg-primary text-white p-2 rounded" style="max-width: 70%; border-radius: 15px; border-top-right-radius: 0;">
                                ${msg.message}
                            </div>
                        </div>`;
                } else {
                    // Tin nhắn của BỆNH NHÂN (Bên trái, màu xám)
                    html += `
                        <div class="d-flex justify-content-start mb-2 align-items-end">
                            <div class="mr-2">
                                <img src="https://ui-avatars.com/api/?name={{ $appointment->user->name }}" class="rounded-circle" width="30">
                            </div>
                            <div class="bg-light text-dark p-2 rounded border" style="max-width: 70%; border-radius: 15px; border-top-left-radius: 0;">
                                <small class="text-muted d-block" style="font-size: 10px;">{{ $appointment->user->name }}</small>
                                ${msg.message}
                            </div>
                        </div>`;
                }
            });
            $('#chat-box').html(html);
        });
    }

    // 2. Polling (2 giây/lần)
    setInterval(fetchMessages, 2000);

    // 3. Gửi tin
    $('#chat-form').submit(function(e) {
        e.preventDefault();
        let message = $('#message-input').val();
        if(message.trim() == '') return;

        $.post(`/appointment/${appointmentId}/messages`, {
            _token: '{{ csrf_token() }}',
            message: message
        }, function(response) {
            $('#message-input').val('');
            fetchMessages();
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    });

    fetchMessages();
</script>
@endsection