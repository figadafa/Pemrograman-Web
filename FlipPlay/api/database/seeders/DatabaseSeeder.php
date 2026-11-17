<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Media;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Media::factory()->anime()->count(3)->create();
        Media::factory()->drama()->count(3)->create();
        Media::factory()->manga()->count(2)->create();
        Media::factory()->lightNovel()->count(2)->create();

        User::factory()->count(3)->create();
    }
}
