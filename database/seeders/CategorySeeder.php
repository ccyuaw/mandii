<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // <--- Nhớ thêm dòng này

class CategorySeeder extends Seeder
{
    public function run()
    {
        // 1. Tắt bảo vệ khóa ngoại (Cho phép xóa bảng cha dù bảng con đang có dữ liệu)
        Schema::disableForeignKeyConstraints();

        // 2. Xóa sạch dữ liệu cũ
        DB::table('categories')->truncate();

        // 3. Bật lại bảo vệ khóa ngoại
        Schema::enableForeignKeyConstraints();

        // 4. Thêm danh mục mới (Giữ nguyên ID cứng để khớp với code ProductSeeder)
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Thuốc kê đơn', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Thực phẩm chức năng', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Thiết bị y tế', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Chăm sóc cá nhân', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}