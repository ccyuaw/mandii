<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeeder extends Seeder
{
    public function run()
    {
        // 1. Xóa dữ liệu cũ (nếu muốn làm mới hoàn toàn)
        // DB::table('specialties')->truncate(); 
        // (Bỏ comment dòng trên nếu bạn muốn xóa hết cái cũ đi tạo lại)

        // 2. Danh sách Chuyên khoa
        $specialties = [
            ['name' => 'Nội khoa', 'description' => 'Khám và điều trị các bệnh lý bên trong cơ thể.'],
            ['name' => 'Ngoại khoa', 'description' => 'Phẫu thuật và điều trị các bệnh lý ngoại khoa.'],
            ['name' => 'Nhi khoa', 'description' => 'Chăm sóc sức khỏe cho trẻ sơ sinh, trẻ em và thanh thiếu niên.'],
            ['name' => 'Sản phụ khoa', 'description' => 'Chăm sóc sức khỏe phụ nữ và thai kỳ.'],
            ['name' => 'Da liễu', 'description' => 'Điều trị các bệnh về da, tóc và móng.'],
            ['name' => 'Tim mạch', 'description' => 'Điều trị các bệnh lý về tim và mạch máu.'],
            ['name' => 'Tai Mũi Họng', 'description' => 'Điều trị các bệnh lý vùng tai, mũi và họng.'],
            ['name' => 'Răng Hàm Mặt', 'description' => 'Chăm sóc và điều trị các vấn đề về răng miệng.'],
            ['name' => 'Mắt (Nhãn khoa)', 'description' => 'Điều trị các bệnh lý về mắt.'],
            ['name' => 'Thần kinh', 'description' => 'Điều trị các rối loạn hệ thần kinh.'],
            ['name' => 'Tiêu hóa', 'description' => 'Điều trị các bệnh lý về đường tiêu hóa, gan mật.'],
            ['name' => 'Cơ Xương Khớp', 'description' => 'Điều trị các bệnh lý về xương khớp, cột sống.'],
            ['name' => 'Ung bướu', 'description' => 'Tầm soát và điều trị ung thư.'],
            ['name' => 'Y học cổ truyền', 'description' => 'Khám chữa bệnh bằng phương pháp đông y.'],
            ['name' => 'Tâm lý', 'description' => 'Tư vấn và điều trị các vấn đề tâm lý, sức khỏe tâm thần.'],
        ];

        // 3. Chèn vào Database
        foreach ($specialties as $item) {
            DB::table('specialties')->insert([
                'name' => $item['name'],
                'description' => $item['description'], // Nếu bảng của bạn có cột description
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}