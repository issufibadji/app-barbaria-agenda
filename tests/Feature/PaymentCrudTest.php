<?php

namespace Tests\Feature;

use App\Models\AgendaAiPayment;
use App\Models\AgendaAiPlan;
use App\Models\AgendaAiEstablishment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_can_be_created(): void
    {
        $plan = AgendaAiPlan::factory()->create();
        $establishment = AgendaAiEstablishment::factory()->create();
        $establishment->refresh();
        $establishmentId = $establishment->getAttribute('id');

        $response = $this->post(route('payments.store', absolute: false), [
            'plan_id' => $plan->id,
            'establishment_id' => $establishmentId,
            'mercado_payment_id' => 'abc123',
        ]);

        $response->assertRedirect(route('payments.index', absolute: false));
        $this->assertDatabaseHas('agendaai_payments', [
            'plan_id' => $plan->id,
            'establishment_id' => $establishmentId,
            'mercado_payment_id' => 'abc123',
        ]);
    }

    public function test_payment_can_be_updated(): void
    {
        $plan = AgendaAiPlan::factory()->create();
        $establishment = AgendaAiEstablishment::factory()->create();
        $establishment->refresh();
        $establishmentId = $establishment->getAttribute('id');

        $payment = AgendaAiPayment::create([
            'plan_id' => $plan->id,
            'establishment_id' => $establishmentId,
            'mercado_payment_id' => 'initial',
        ]);

        $newPlan = AgendaAiPlan::factory()->create();
        $newEst = AgendaAiEstablishment::factory()->create();
        $newEst->refresh();
        $newEstId = $newEst->getAttribute('id');

        $response = $this->put(route('payments.update', $payment->id, absolute: false), [
            'plan_id' => $newPlan->id,
            'establishment_id' => $newEstId,
            'mercado_payment_id' => 'zzz999',
        ]);

        $response->assertRedirect(route('payments.index', absolute: false));
        $this->assertDatabaseHas('agendaai_payments', [
            'id' => $payment->id,
            'plan_id' => $newPlan->id,
            'establishment_id' => $newEstId,
            'mercado_payment_id' => 'zzz999',
        ]);
    }

    public function test_payment_can_be_deleted(): void
    {
        $plan = AgendaAiPlan::factory()->create();
        $est = AgendaAiEstablishment::factory()->create();
        $est->refresh();
        $estId = $est->getAttribute('id');
        $payment = AgendaAiPayment::create([
            'plan_id' => $plan->id,
            'establishment_id' => $estId,
            'mercado_payment_id' => 'todelete',
        ]);

        $response = $this->delete(route('payments.destroy', $payment->id, absolute: false));

        $response->assertRedirect(route('payments.index', absolute: false));
        $this->assertDatabaseMissing('agendaai_payments', ['id' => $payment->id]);
    }
}
