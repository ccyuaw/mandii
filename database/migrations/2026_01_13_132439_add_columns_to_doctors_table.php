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
    Schema::table('doctors', function (Blueprint $table) {
        $table->integer('experience_years')->default(1); // Số năm kinh nghiệm
        $table->integer('consultation_count')->default(0); // Số lượt tư vấn
        $table->float('rating')->default(5.0); // Đánh giá sao (ví dụ: 4.8)
        $table->string('old_price')->nullable(); // Giá cũ (để gạch đi)
        $table->text('work_history')->nullable(); // Quá trình công tác (HTML)
        $table->text('education')->nullable(); // Học vấn (HTML)
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            //
        });
    }
};
