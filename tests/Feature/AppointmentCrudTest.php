<?php

namespace Tests\Feature;

use App\Models\AgendaAiAppointment;
use App\Models\AgendaAiClient;
use App\Models\AgendaAiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_appointment_can_be_created(): void
    {
        $service = AgendaAiService::factory()->create();
        $service->refresh();
        $serviceId = $service->getAttribute('id');
        $client = AgendaAiClient::factory()->create();
        $client->refresh();
        $clientId = $client->getAttribute('id');

        $response = $this->post(route('appointments.store', absolute: false), [
            'service_id' => $serviceId,
            'client_id' => $clientId,
            'scheduled_at' => now()->addDay()->format('Y-m-d H:i:s'),
            'status' => 'pendente',
        ]);

        $response->assertRedirect(route('appointments.index', absolute: false));
        $this->assertDatabaseHas('agendaai_appointments', [
            'service_id' => $serviceId,
            'client_id' => $clientId,
        ]);
    }

    public function test_appointment_can_be_updated(): void
    {
        $appointment = AgendaAiAppointment::factory()->create();
        $appointment->refresh();

        $response = $this->put(route('appointments.update', $appointment->id, absolute: false), [
            'service_id' => $appointment->service_id,
            'client_id' => $appointment->client_id,
            'scheduled_at' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'status' => 'confirmado',
        ]);

        $response->assertRedirect(route('appointments.index', absolute: false));
        $this->assertDatabaseHas('agendaai_appointments', [
            'id' => $appointment->id,
            'status' => 'confirmado',
        ]);
    }

    public function test_appointment_can_be_deleted(): void
    {
        $appointment = AgendaAiAppointment::factory()->create();

        $response = $this->delete(route('appointments.destroy', $appointment->id, absolute: false));

        $response->assertRedirect(route('appointments.index', absolute: false));
        $this->assertDatabaseMissing('agendaai_appointments', ['id' => $appointment->id]);
    }
}
