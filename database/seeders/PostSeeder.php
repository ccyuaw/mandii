<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Tạo Admin nếu chưa có
        $admin = User::firstOrCreate(
            ['email' => 'admin@mandi.com'],
            [
                'name' => 'Ban Biên Tập Mandi',
                'password' => bcrypt('12345678'),
                'role' => 'admin'
            ]
        );

        // Danh sách bài viết kèm Link ảnh thật (Y tế/Sức khỏe)
        $posts = [
            [
                'title' => '10 Thực phẩm vàng cho sức khỏe tim mạch',
                'image' => 'https://images.unsplash.com/photo-1598449356475-b9f71db7d847?auto=format&fit=crop&q=80&w=800', // Ảnh rau củ
                'topic' => 'Dinh dưỡng'
            ],
            [
                'title' => 'Lợi ích bất ngờ của việc chạy bộ mỗi sáng',
                'image' => 'https://images.unsplash.com/photo-1552674605-5d226875b223?auto=format&fit=crop&q=80&w=800', // Ảnh chạy bộ
                'topic' => 'Vận động'
            ],
            [
                'title' => 'Cách sơ cứu nhanh khi bị bỏng tại nhà',
                'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&q=80&w=800', // Ảnh dụng cụ y tế
                'topic' => 'Sơ cứu'
            ],
            [
                'title' => 'Tại sao bạn nên uống đủ 2 lít nước mỗi ngày?',
                'image' => 'https://images.unsplash.com/photo-1548839140-29a749e1cf4d?auto=format&fit=crop&q=80&w=800', // Ảnh nước
                'topic' => 'Đời sống'
            ],
            [
                'title' => 'Yoga cho người mới bắt đầu: 5 tư thế cơ bản',
                'image' => 'https://images.unsplash.com/photo-1544367563-12123d8975bd?auto=format&fit=crop&q=80&w=800', // Ảnh Yoga
                'topic' => 'Tập luyện'
            ],
            [
                'title' => 'Hiểu đúng về bệnh tiểu đường Type 2',
                'image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&q=80&w=800', // Ảnh bác sĩ
                'topic' => 'Bệnh lý'
            ],
            [
                'title' => 'Bí quyết chăm sóc da mùa hanh khô',
                'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?auto=format&fit=crop&q=80&w=800', // Ảnh skincare
                'topic' => 'Làm đẹp'
            ],
            [
                'title' => 'Vaccine cúm mùa: Những điều cần biết',
                'image' => 'https://images.unsplash.com/photo-1624727828489-a1e03b79bba8?auto=format&fit=crop&q=80&w=800', // Ảnh vaccine
                'topic' => 'Tiêm chủng'
            ],
        ];

        foreach ($posts as $post) {
            Post::create([
                'title' => $post['title'],
                'excerpt' => 'Tóm tắt ngắn gọn về chủ đề ' . $post['topic'] . '. Bài viết này cung cấp những thông tin y khoa chính xác và hữu ích nhất...',
                'content' => '
                    <p><strong>' . $post['title'] . '</strong> là vấn đề được nhiều người quan tâm.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <h3>1. Lợi ích chính</h3>
                    <p>Nội dung chi tiết về lợi ích. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <img src="' . $post['image'] . '" style="width:100%; border-radius:8px; margin: 10px 0;">
                    <h3>2. Lời khuyên chuyên gia</h3>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                ',
                'image' => $post['image'], // Lưu thẳng Link ảnh vào DB
                'user_id' => $admin->id,
                'is_published' => true,
            ]);
        }
    }
}