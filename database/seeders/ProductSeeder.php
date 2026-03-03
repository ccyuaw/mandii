<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Danh sách thuốc (Gán thẳng vào ID 1, 2, 3, 4 đã có)
        // LƯU Ý: BẠN CẦN TẢI ẢNH VỀ VÀ ĐẶT VÀO THƯ MỤC public/images/products/ TRƯỚC NHÉ!
        $products = [
            // --- NHÓM 1: THUỐC KÊ ĐƠN (ID = 1) ---
            [
                'category_id' => 1,
                'name' => 'Panadol Extra (Hộp đỏ)',
                'price' => 25000,
                'stock' => 100,
                'unit' => 'Vỉ 12 viên',
                'description' => 'Thuốc giảm đau hạ sốt hiệu quả nhanh.',
                // Thay đường dẫn online bằng đường dẫn file trong máy
                'image' => '/images/products/panadol-extra.jpg'
            ],
            [
                'category_id' => 1,
                'name' => 'Efferalgan 500mg',
                'price' => 60000,
                'stock' => 50,
                'unit' => 'Tuýp 16 viên',
                'description' => 'Giảm đau, hạ sốt nhanh chóng dạng sủi.',
                'image' => '/images/products/efferalgan-500mg.jpg'
            ],

            // --- NHÓM 2: THỰC PHẨM CHỨC NĂNG (ID = 2) ---
            [
                'category_id' => 2,
                'name' => 'Vitamin C Berocca',
                'price' => 180000,
                'stock' => 200,
                'unit' => 'Hộp',
                'description' => 'Bổ sung Vitamin C và Kẽm, tăng đề kháng.',
                'image' => '/images/products/vitamin-c-berocca.jpg'
            ],
            [
                'category_id' => 2,
                'name' => 'Dầu cá Omega-3',
                'price' => 350000,
                'stock' => 60,
                'unit' => 'Lọ',
                'description' => 'Tốt cho tim mạch và sáng mắt.',
                'image' => '/images/products/dau-ca-omega3.jpg'
            ],

            // --- NHÓM 3: THIẾT BỊ Y TẾ (ID = 3) ---
            [
                'category_id' => 3,
                'name' => 'Máy đo huyết áp Omron',
                'price' => 850000,
                'stock' => 20,
                'unit' => 'Bộ',
                'description' => 'Đo huyết áp bắp tay tự động.',
                'image' => '/images/products/may-do-huyet-ap-omron.jpg'
            ],

            // --- NHÓM 4: CHĂM SÓC CÁ NHÂN (ID = 4) ---
            [
                'category_id' => 4,
                'name' => 'Nước súc miệng Listerine',
                'price' => 120000,
                'stock' => 100,
                'unit' => 'Chai',
                'description' => 'Diệt khuẩn, thơm miệng.',
                'image' => '/images/products/nuoc-suc-mieng-listerine.jpg'
            ],
        ];

        foreach ($products as $prod) {
            // Sử dụng updateOrCreate để cập nhật ảnh nếu sản phẩm đã tồn tại
            Product::updateOrCreate(
                ['name' => $prod['name']], // Tìm theo tên
                $prod // Cập nhật (hoặc tạo mới) với dữ liệu này
            );
        }
    }
}