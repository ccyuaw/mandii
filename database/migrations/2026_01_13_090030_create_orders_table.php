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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Ai mua?
        $table->string('customer_name'); // Tên người nhận (có thể khác tên user)
        $table->string('customer_phone');
        $table->string('customer_address');
        $table->text('note')->nullable(); // Ghi chú giao hàng
        
        $table->decimal('total_price', 15, 0); // Tổng tiền đơn hàng
        $table->string('payment_method')->default('COD'); // COD hoặc VNPAY
        $table->string('status')->default('pending'); // pending, shipping, completed, cancelled
        
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
        Schema::dropIfExists('orders');
    }
};
