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
    Schema::table('user_tried_stored_questions', function (Blueprint $table) {
        // 💡 unsignedBigInteger('question_id') カラムを NULL を許容するように変更
        // change() メソッドを使用
        $table->unsignedBigInteger('question_id')->nullable()->change();
    });
}

// 必要に応じて、元に戻せるよう down() メソッドも設定しておくと安全です
public function down(): void
{
    Schema::table('user_tried_stored_questions', function (Blueprint $table) {
        // 💡 NOT NULL に戻す（データがないと失敗するため、注意が必要です）
        $table->unsignedBigInteger('question_id')->nullable(false)->change();
    });
}
};
