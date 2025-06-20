<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'establishment_name' => 'Barbearia Teste',
            'phone' => '123456789',
        ]);

        $this->assertAuthenticated();
        $establishment = \App\Models\AgendaAiEstablishment::first();
        $response->assertRedirect(route('establishments.edit', $establishment->uuid, absolute: false));
    }
}
