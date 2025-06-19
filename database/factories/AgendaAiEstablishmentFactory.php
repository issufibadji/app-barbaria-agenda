<?php

namespace Database\Factories;

use App\Models\AgendaAiEstablishment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AgendaAiEstablishmentFactory extends Factory
{
    protected $model = AgendaAiEstablishment::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'name' => $this->faker->company(),
            'link' => $this->faker->url(),
            'manual_chat_link' => $this->faker->url(),
            'descrition' => $this->faker->sentence(),
            'image' => null,
            'user_id' => User::factory(),
        ];
    }
}
