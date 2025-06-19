<?php

namespace Tests\Feature;

use App\Models\AgendaAiService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_can_be_created(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('services.store', absolute: false), [
            'name' => 'Corte',
            'duration_min' => 30,
            'price' => 50,
            'descrition' => 'Desc',
        ]);

        $response->assertRedirect(route('services.index', absolute: false));
        $this->assertDatabaseHas('agendaai_services', [
            'name' => 'Corte',
            'user_id' => $user->id,
        ]);
    }

    public function test_service_can_be_updated(): void
    {
        $user = User::factory()->create();
        $service = AgendaAiService::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('services.update', $service->uuid, absolute: false), [
            'name' => 'Updated',
            'duration_min' => $service->duration_min,
            'price' => $service->price,
            'descrition' => 'Updated desc',
        ]);

        $response->assertRedirect(route('services.index', absolute: false));
        $this->assertDatabaseHas('agendaai_services', [
            'uuid' => $service->uuid,
            'name' => 'Updated',
            'descrition' => 'Updated desc',
        ]);
    }

    public function test_service_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $service = AgendaAiService::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('services.destroy', $service->uuid, absolute: false));

        $response->assertRedirect(route('services.index', absolute: false));
        $this->assertDatabaseMissing('agendaai_services', ['uuid' => $service->uuid]);
    }
}
