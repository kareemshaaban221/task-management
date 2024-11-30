<?php

namespace Database\Seeders;

use App\Models\Task;
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
        // create defualt user
        User::factory()->create(config('seeds.users.default'));
        // create random users
        User::factory(10)->create();
        // create random tasks
        Task::factory(500)->create();
    }
}
