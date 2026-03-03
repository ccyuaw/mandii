<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OllamaService
{
    // Cấu hình kết nối đến Ollama đang chạy trên máy bạn
    protected $baseUrl = 'http://127.0.0.1:11434/api/generate';
    
    // Tên model bạn vừa tải (nếu tải qwen2 thì để 'qwen2', nếu gemma thì đổi thành 'gemma:2b')
    protected $model = 'qwen2'; 

    public function ask($prompt)
    {
        try {
            // Gọi API đến Ollama
            $response = Http::timeout(120) // Tăng timeout lên 120s vì máy cá nhân chạy AI hơi lâu
                ->post($this->baseUrl, [
                    'model' => $this->model,
                    'prompt' => $prompt,
                    'stream' => false, // Tắt stream để nhận kết quả 1 lần cho dễ xử lý
                    'options' => [
                        'temperature' => 0.7, // Độ sáng tạo (0.7 là vừa phải, không bịa đặt quá)
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['response'] ?? "Xin lỗi, AI không trả về kết quả.";
            }
            
            Log::error('Ollama Error: ' . $response->body());
            return "Hệ thống AI đang quá tải, vui lòng thử lại sau.";

        } catch (\Exception $e) {
            Log::error('Ollama Exception: ' . $e->getMessage());
            return "Không thể kết nối đến máy chủ AI (Hãy chắc chắn bạn đã bật Ollama).";
        }
    }
}