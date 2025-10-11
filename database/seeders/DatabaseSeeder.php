<?php

namespace Database\Seeders;
use Database\Seeders\StoredQuestionSeeder;


use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory(10)->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // UserSeederはデフォルトで存在しないが、User::factory()を使えば自動的に生成される
        // まずはUserを作成（10件）
        User::factory(10)->create();

        // 2. StoredQuestionをシード
        $this->call([
            StoredQuestionSeeder::class,
            TestUserSeeder::class,
            UserQuestionDataSeeder::class,
        ]);

        
    }
}
