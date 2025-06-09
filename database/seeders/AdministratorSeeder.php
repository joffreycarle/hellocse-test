<?php

namespace Database\Seeders;

use App\Models\Administrator;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Administrator::factory(['name' => 'Test Administrator', 'email' => 'test@test.com'])->create();
        Administrator::factory()->count(5)->create();
    }
}
