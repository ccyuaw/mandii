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
        // Xóa cột cũ gây lỗi
        if (Schema::hasColumn('doctors', 'specialty')) {
            $table->dropColumn('specialty');
        }
    });
}

public function down()
{
    Schema::table('doctors', function (Blueprint $table) {
        // Khôi phục lại nếu cần rollback (dự phòng)
        $table->string('specialty')->nullable();
    });
}
};
