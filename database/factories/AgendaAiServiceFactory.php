<?php

namespace Database\Factories;

use App\Models\AgendaAiService;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AgendaAiServiceFactory extends Factory
{
    protected $model = AgendaAiService::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'name' => $this->faker->words(2, true),
            'duration_min' => $this->faker->numberBetween(15, 120),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'descrition' => $this->faker->sentence(),
            'user_id' => User::factory(),
            'image' => null,
        ];
    }
}
