<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // パスワードのハッシュ化に必要

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 既存ユーザーがいなければ作成
        User::firstOrCreate(
            ['email' => 'test@example.com'], // 検索キー
            [
                'name' => 'Test User',
                'password' => Hash::make('password'), // 💡 パスワードは「password」で設定
                'email_verified_at' => now(),
            ]
        );

        // 💡 既存ユーザー（ID: 12）のパスワードをリセットする（デバッグ用）
        // User::where('id', 12)->update(['password' => Hash::make('password')]);
    }
}