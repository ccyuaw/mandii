@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-6">
    <div class="max-w-4xl mx-auto px-4">
        
        {{-- Header Phòng chat --}}
        <div class="bg-white rounded-t-xl border-b border-slate-200 p-4 flex justify-between items-center shadow-sm">
            <div class="flex items-center gap-3">
                <a href="{{ route('booking.history') }}" class="text-slate-400 hover:text-blue-600">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-bold text-slate-800 text-lg">
                        Chat với BS. {{ $appointment->doctor->name }}
                    </h2>
                    <span class="text-xs text-green-500 font-bold flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Đang trực tuyến
                    </span>
                </div>
            </div>
            
            {{-- Nút gọi video (Để làm sau) --}}
            <button class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition flex items-center justify-center">
                <i class="fa-solid fa-video"></i>
            </button>
        </div>

        {{-- KHUNG CHAT (Nơi hiện tin nhắn) --}}
        <div id="chat-box" class="bg-white h-[500px] overflow-y-auto p-4 space-y-4 bg-slate-50">
            {{-- Tin nhắn sẽ được JS nạp vào đây --}}
            <div class="text-center text-slate-400 text-sm mt-10">Đang tải cuộc trò chuyện...</div>
        </div>

        {{-- KHUNG NHẬP LIỆU --}}
        <div class="bg-white p-4 rounded-b-xl border-t border-slate-200 shadow-sm">
            <form id="chat-form" class="flex gap-2">
                <input type="text" id="message-input" 
                       class="flex-1 border border-slate-300 rounded-full px-4 py-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                       placeholder="Nhập tin nhắn..." autocomplete="off">
                <button type="submit" class="bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-blue-700 transition">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>

    </div>
</div>

{{-- SCRIPT XỬ LÝ CHAT (AJAX) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const appointmentId = {{ $appointment->id }};
    const currentUserId = {{ Auth::id() }};
    const chatBox = document.getElementById('chat-box');

    // 1. Hàm tải tin nhắn
    function fetchMessages() {
        $.get(`/appointment/${appointmentId}/messages`, function(messages) {
            let html = '';
            messages.forEach(msg => {
                // Kiểm tra xem tin nhắn của mình hay của người khác
                let isMe = (msg.user_id == currentUserId);
                
                if (isMe) {
                    // Tin nhắn của TÔI (Bên phải, màu xanh)
                    html += `
                        <div class="flex justify-end">
                            <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl rounded-tr-none max-w-[70%] text-sm shadow-sm">
                                ${msg.message}
                            </div>
                        </div>`;
                } else {
                    // Tin nhắn của NGƯỜI KHÁC (Bên trái, màu xám)
                    html += `
                        <div class="flex justify-start items-end gap-2">
                            <div class="bg-slate-200 text-slate-800 px-4 py-2 rounded-2xl rounded-tl-none max-w-[70%] text-sm">
                                ${msg.message}
                            </div>
                        </div>`;
                }
            });
            $('#chat-box').html(html);
        });
    }

    // 2. Tự động tải tin nhắn mỗi 2 giây
    setInterval(fetchMessages, 2000);

    // 3. Gửi tin nhắn
    $('#chat-form').submit(function(e) {
        e.preventDefault();
        let message = $('#message-input').val();
        
        if(message.trim() == '') return;

        // Gửi lên server
        $.post(`/appointment/${appointmentId}/messages`, {
            _token: '{{ csrf_token() }}',
            message: message
        }, function(response) {
            $('#message-input').val(''); // Xóa ô nhập
            fetchMessages(); // Tải lại ngay lập tức
            
            // Cuộn xuống dưới cùng
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    });

    // Tải lần đầu
    fetchMessages();
</script>
@endsection