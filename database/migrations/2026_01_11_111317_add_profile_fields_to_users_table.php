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
    Schema::table('users', function (Blueprint $table) {
        // Thêm các cột mới nếu chưa có
        if (!Schema::hasColumn('users', 'phone')) $table->string('phone')->nullable();
        if (!Schema::hasColumn('users', 'address')) $table->string('address')->nullable();
        if (!Schema::hasColumn('users', 'avatar')) $table->string('avatar')->nullable();
        if (!Schema::hasColumn('users', 'birthday')) $table->date('birthday')->nullable();
        if (!Schema::hasColumn('users', 'gender')) $table->string('gender')->nullable();
        if (!Schema::hasColumn('users', 'medical_history')) $table->text('medical_history')->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['phone', 'address', 'avatar', 'birthday', 'gender', 'medical_history']);
    });
}
};
