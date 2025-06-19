<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::count() === 0) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        } else {
            $user = User::first();
        }

        if (Category::count() === 0) {
            Category::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);
        }

        if (Task::count() === 0) {
            Task::factory()->count(5)->create([
                'user_id' => $user->id,
                'category_id' => Category::first()->id,
            ]);
        }
    }
}
