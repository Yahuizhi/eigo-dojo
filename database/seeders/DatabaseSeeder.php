<?php

namespace Database\Seeders;
use Database\Seeders\StoredQuestionSeeder;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create();

        $this->call([
            StoredQuestionSeeder::class,
            TestUserSeeder::class,
            UserQuestionDataSeeder::class,
        ]);        
    }
}
