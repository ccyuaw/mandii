<?php

namespace App\Http\Controllers;
use App\Services\OllamaService;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // Dùng để gọi API AI sau này

class ChatBotController extends Controller
{
    // 1. Hiển thị giao diện chat
    public function index()
    {
        // Lấy 50 tin nhắn gần nhất của user hiện tại
        $messages = ChatMessage::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();
            
        return view('ai.chat', compact('messages'));
    }

    // 2. Xử lý tin nhắn người dùng gửi lên
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->message;

        // B1: Lưu tin nhắn của User vào DB
        ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $userMessage,
            'sender'  => 'user'
        ]);

        // B2: Gọi AI xử lý (Đây là logic AI)
        $botReply = $this->getAIResponse($userMessage);

        // B3: Lưu câu trả lời của Bot vào DB
        ChatMessage::create([
            'user_id' => Auth::id(),
            'message' => $botReply,
            'sender'  => 'bot'
        ]);

        return response()->json(['reply' => $botReply]);
    }

    // === HÀM XỬ LÝ TRÍ TUỆ NHÂN TẠO (QUAN TRỌNG) ===
    // === HÀM XỬ LÝ TRÍ TUỆ NHÂN TẠO (NÂNG CẤP) ===
    private function getAIResponse($input)
    {
        // 1. Chuẩn hóa chuỗi nhập vào (chuyển về chữ thường)
        $input = mb_strtolower($input, 'UTF-8');

        // 2. Load dữ liệu từ file config/medical_knowledge.php
        $knowledgeBase = config('medical_knowledge');

        // 3. Logic tìm kiếm (Rule-based Matching)
        // Duyệt qua từng bộ câu hỏi trong cơ sở dữ liệu
        foreach ($knowledgeBase as $item) {
            foreach ($item['keywords'] as $keyword) {
                // Kiểm tra xem từ khóa có nằm trong câu hỏi của người dùng không
                if (str_contains($input, $keyword)) {
                    return $item['answer'];
                }
            }
        }

        if (str_contains($input, 'chào') || str_contains($input, 'hello')) {
    return "Chào bạn! Mình là Mandi - Trợ lý sức khỏe của bạn. Hôm nay bạn cảm thấy trong người thế nào? (Ví dụ: Bạn đau đầu, sốt, hay mệt mỏi... cứ kể cho Mandi nghe nhé!)";
}
if (str_contains($input, 'cảm ơn')) {
    return "Không có chi! Được hỗ trợ bạn là niềm vui của Mandi. Chúc bạn và gia đình luôn mạnh khỏe nhé! ❤️";
}
if (str_contains($input, 'tạm biệt')) {
    return "Tạm biệt bạn! Nhớ giữ gìn sức khỏe và quay lại với Mandi bất cứ khi nào bạn cần nhé.";
}

// 5. Câu trả lời mặc định (Khi không hiểu)
return "Mandi xin lỗi, mình chưa hiểu rõ triệu chứng này lắm. Bạn có thể mô tả chi tiết hơn chút nữa không? Hoặc tốt nhất, bạn hãy đặt lịch khám với bác sĩ chuyên khoa trên hệ thống để được chẩn đoán chính xác nhé.";
    }
    public function askOllama($question) {
    $response = Http::timeout(60)->post('http://127.0.0.1:11434/api/generate', [
        'model' => 'vistral', // Hoặc 'llama3', 'vinallama'
        'prompt' => "Bạn là trợ lý y tế ảo Mandi. Hãy trả lời câu hỏi sau ngắn gọn, thân thiện: " . $question,
        'stream' => false
    ]);

    return $response->json()['response'];
}
}