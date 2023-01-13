<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->sentence,
            'user_id' => (User::factory()->create())->id
        ];
    }
}
