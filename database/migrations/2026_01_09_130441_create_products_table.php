<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->string('name'); // Tên thuốc
        $table->decimal('price', 10, 0); // Giá tiền
        $table->string('image')->nullable(); // Ảnh thuốc
        $table->text('description')->nullable(); // Công dụng/Mô tả
        $table->string('unit')->default('Hộp'); // Đơn vị tính (Hộp/Vỉ/Chai)
        $table->integer('stock')->default(0); // Số lượng tồn kho
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
