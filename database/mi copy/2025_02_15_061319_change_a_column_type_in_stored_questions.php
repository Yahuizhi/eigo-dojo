<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // 新しく生成されたマイグレーションファイル内
public function up()
{
    Schema::table('stored_questions', function (Blueprint $table) {
        $table->text('A')->change(); // 'A' カラムを TEXT 型に変更
    });
}

public function down()
{
    Schema::table('stored_questions', function (Blueprint $table) {
        $table->string('A', 255)->change(); // 元に戻す
    });
}

};
