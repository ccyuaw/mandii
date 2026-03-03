@extends('layouts.app')

@section('content')
<div class="h-[calc(100vh-80px)] bg-slate-100 flex flex-col">
    <div class="bg-white shadow px-6 py-4 flex items-center gap-4 shrink-0 z-10">
        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-cyan-400 flex items-center justify-center text-white shadow-lg">
            <i class="fa-solid fa-robot text-xl"></i>
        </div>
        <div>
            <h1 class="font-bold text-lg text-slate-800">Mandi AI Assistant</h1>
            <p class="text-xs text-green-500 font-bold flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Đang trực tuyến
            </p>
        </div>
    </div>

    <div id="chat-box" class="flex-1 overflow-y-auto p-4 space-y-4 scroll-smooth">
        
        <div class="flex gap-3">
            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                <i class="fa-solid fa-robot"></i>
            </div>
            <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[80%] text-slate-700 text-sm">
                Chào {{ Auth::user()->name }}! 👋 Tôi là trợ lý AI. Bạn đang gặp vấn đề sức khỏe gì? (Ví dụ: Đau đầu, sốt, mất ngủ...)
            </div>
        </div>

        @foreach($messages as $msg)
            @if($msg->sender == 'user')
                <div class="flex gap-3 flex-row-reverse">
                    <div class="bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none shadow-sm max-w-[80%] text-sm">
                        {{ $msg->message }}
                    </div>
                </div>
            @else
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[80%] text-slate-700 text-sm">
                        {{ $msg->message }}
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="bg-white p-4 border-t border-slate-200 shrink-0">
        <form id="chat-form" class="max-w-4xl mx-auto relative flex items-center gap-2">
            @csrf
            <input type="text" id="message-input" 
                   class="w-full bg-slate-100 border-0 rounded-full px-6 py-3 focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                   placeholder="Nhập triệu chứng của bạn..." autocomplete="off">
            
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition transform active:scale-95">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

{{-- SCRIPT XỬ LÝ AJAX --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const chatBox = $('#chat-box');
        
        // Tự động cuộn xuống cuối khi vào trang
        chatBox.scrollTop(chatBox[0].scrollHeight);

        $('#chat-form').submit(function(e) {
            e.preventDefault();
            
            let message = $('#message-input').val().trim();
            if(message == '') return;

            // 1. Hiển thị tin nhắn người dùng ngay lập tức
            appendMessage('user', message);
            $('#message-input').val('');

            // 2. Hiển thị hiệu ứng "Đang nhập..."
            let loadingHtml = `
                <div id="loading-dots" class="flex gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm text-slate-500 text-sm flex gap-1">
                        <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce"></span>
                        <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                        <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                    </div>
                </div>`;
            chatBox.append(loadingHtml);
            chatBox.scrollTop(chatBox[0].scrollHeight);

            // 3. Gửi Ajax lên Server
            $.ajax({
                url: "{{ route('ai.send') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    message: message
                },
                success: function(response) {
                    $('#loading-dots').remove(); // Xóa hiệu ứng loading
                    appendMessage('bot', response.reply); // Hiển thị tin nhắn Bot
                },
                error: function() {
                    $('#loading-dots').remove();
                    appendMessage('bot', 'Lỗi kết nối. Vui lòng thử lại.');
                }
            });
        });

        function appendMessage(sender, text) {
            let html = '';
            if(sender == 'user') {
                html = `
                <div class="flex gap-3 flex-row-reverse animate-fade-in-up">
                    <div class="bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none shadow-sm max-w-[80%] text-sm">
                        ${text}
                    </div>
                </div>`;
            } else {
    html = `
    <div class="flex gap-3 animate-fade-in-up">
        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
            <i class="fa-solid fa-user-doctor"></i> </div>
        <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm max-w-[85%] text-slate-700 text-sm leading-relaxed">
            ${text} </div>
    </div>`;
}
            chatBox.append(html);
            chatBox.scrollTop(chatBox[0].scrollHeight);
        }
    });
</script>

<style>
    /* Hiệu ứng tin nhắn hiện lên từ từ */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.3s ease-out forwards;
    }
</style>
@endsection