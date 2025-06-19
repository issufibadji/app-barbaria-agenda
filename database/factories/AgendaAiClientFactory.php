<?php

namespace Database\Factories;

use App\Models\AgendaAiClient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AgendaAiClientFactory extends Factory
{
    protected $model = AgendaAiClient::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'user_id' => User::factory(),
            'gender' => $this->faker->randomElement(['M', 'F']),
        ];
    }
}
