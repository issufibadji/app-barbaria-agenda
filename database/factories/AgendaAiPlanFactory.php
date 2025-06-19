<?php

namespace Database\Factories;

use App\Models\AgendaAiPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgendaAiPlanFactory extends Factory
{
    protected $model = AgendaAiPlan::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'days' => $this->faker->numberBetween(30, 365),
            'active' => true,
            'price' => $this->faker->randomFloat(2, 10, 500),
            'descrition' => $this->faker->sentence(),
            'features' => [],
        ];
    }
}
