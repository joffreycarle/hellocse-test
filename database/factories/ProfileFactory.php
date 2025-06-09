<?php

namespace Database\Factories;

use App\Enums\ProfileStatus;
use App\Models\Administrator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $profileStatuses = ProfileStatus::toArray();

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'status' => $profileStatuses[rand(0, count($profileStatuses) - 1)],
            'administrator_id' => Administrator::factory(),
        ];
    }
}
