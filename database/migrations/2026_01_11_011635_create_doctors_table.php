<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            
            // Liên kết với bảng specialties
            // Lưu ý: Mình thêm chữ 'specialties' vào trong constrained() để đảm bảo nó tìm đúng bảng
            $table->foreignId('specialty_id')->constrained('specialties')->onDelete('cascade'); 
            
            $table->string('name');
            $table->string('phone')->unique(); // Số điện thoại
            $table->string('email')->unique(); // Email
            $table->text('bio')->nullable();   // Giới thiệu
            $table->string('avatar')->nullable(); // Ảnh đại diện
            
            // CHỈ KHAI BÁO CỘT PRICE 1 LẦN DUY NHẤT TẠI ĐÂY:
            $table->integer('price')->default(0); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctors');
    }
};