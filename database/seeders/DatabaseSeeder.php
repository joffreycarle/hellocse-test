<?php

namespace Database\Seeders;

use App\Enums\ProfileStatus;
use App\Models\Administrator;
use App\Models\Profile;
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
        $this->call([
            AdministratorSeeder::class,
            ProfileSeeder::class,
        ]);
    }
}
