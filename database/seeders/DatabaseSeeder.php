<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            // 1. Phải có danh mục trước
        CategorySeeder::class, 
        
        // 2. Sau đó mới tạo sản phẩm (thuốc) vào danh mục
        ProductSeeder::class,
        PostSeeder::class,   // Seeder bài viết cũ
        DoctorSeeder::class, // <--- THÊM DÒNG NÀY (Seeder bác sĩ mới)
    ]);
    }
}
