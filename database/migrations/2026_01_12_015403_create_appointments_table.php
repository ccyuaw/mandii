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
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        // Liên kết với bảng users (người đặt)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // Liên kết với bảng doctors (bác sĩ được chọn)
        $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
        
        $table->dateTime('appointment_time'); // Thời gian hẹn
        $table->string('status')->default('pending'); // Trạng thái: pending, confirmed, cancelled
        $table->text('note')->nullable(); // Ghi chú của bệnh nhân
        $table->timestamps();
        $table->integer('price')->default(0);
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
