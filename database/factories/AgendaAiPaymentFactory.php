<?php

namespace Database\Factories;

use App\Models\AgendaAiPayment;
use App\Models\AgendaAiPlan;
use App\Models\AgendaAiEstablishment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AgendaAiPaymentFactory extends Factory
{
    protected $model = AgendaAiPayment::class;

    public function definition(): array
    {
        return [
            'plan_id' => AgendaAiPlan::factory(),
            'establishment_id' => AgendaAiEstablishment::factory(),
            'mercado_payment_id' => Str::random(10),
        ];
    }
}
