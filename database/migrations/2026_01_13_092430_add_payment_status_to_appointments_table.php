<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Thêm cột payment_status vào bảng APPOINTMENTS (nếu chưa có)
        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function (Blueprint $table) {
                if (!Schema::hasColumn('appointments', 'payment_status')) {
                    $table->string('payment_status')->default('unpaid')->after('status'); // Hoặc after cột nào bạn muốn
                }
                
                // LƯU Ý: XÓA DÒNG THÊM 'price' VÌ DB CỦA BẠN ĐÃ CÓ RỒI
                // $table->decimal('price', 15, 0)... -> Xóa dòng này đi
            });
        }

        // 2. Thêm cột payment_status vào bảng ORDERS (nếu chưa có - phòng hờ)
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'payment_status')) {
                    $table->string('payment_status')->default('unpaid')->after('total_price');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function (Blueprint $table) {
                if (Schema::hasColumn('appointments', 'payment_status')) {
                    $table->dropColumn('payment_status');
                }
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'payment_status')) {
                    $table->dropColumn('payment_status');
                }
            });
        }
    }
};