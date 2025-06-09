<?php

namespace Database\Seeders;

use App\Enums\ProfileStatus;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::factory()->count(5)->create();
        // Create 5 active profiles, each with 1 comment with 1 administrator associated
        Profile::factory(['status' => ProfileStatus::Active->value])->count(5)->hasComments(1)->create();
    }
}
