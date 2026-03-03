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
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Tiêu đề bài viết
        $table->text('excerpt')->nullable(); // Đoạn tóm tắt ngắn
        $table->longText('content'); // Nội dung chi tiết (Dùng CKEditor/Summernote sau này)
        $table->string('image')->nullable(); // Ảnh bìa
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Người viết
        $table->boolean('is_published')->default(true); // Trạng thái ẩn/hiện
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
        Schema::dropIfExists('posts');
    }
};
