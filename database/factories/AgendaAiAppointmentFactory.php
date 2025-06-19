<?php

namespace Database\Factories;

use App\Models\AgendaAiAppointment;
use App\Models\AgendaAiService;
use App\Models\AgendaAiClient;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgendaAiAppointmentFactory extends Factory
{
    protected $model = AgendaAiAppointment::class;

    public function definition(): array
    {
        return [
            'service_id' => function () {
                $service = AgendaAiService::factory()->create();
                $service->refresh();
                return $service->getAttribute('id');
            },
            'client_id' => function () {
                $client = AgendaAiClient::factory()->create();
                $client->refresh();
                return $client->getAttribute('id');
            },
            'scheduled_at' => now()->addDay(),
            'status' => 'pendente',
        ];
    }
}
