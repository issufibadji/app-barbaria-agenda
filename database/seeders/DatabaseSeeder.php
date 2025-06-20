<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria usuários fictícios
        User::factory(10)->create();

        // Executa os seeders dependentes
        $this->call([
            RoleAndPermissionSeeder::class,
            MenuSidebarSeeder::class, // ✅ Seeder dos Menus
            AppConfigSeeder::class,
            MessageSettingsSeeder::class
        ]);

        // Usuário super master
        $super = User::factory()->create([
            'name' => 'Super Master',
            'email' => 'super@agender.com',
        ]);

        // Usuário master
        $master = User::factory()->create([
            'name' => 'Master TI',
            'email' => 'master@agender.com',
        ]);

        // Usuário admin (gestor de barbearia)
        $admin = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@agender.com',
        ]);

        // Profissional colaborador
        $professional = User::factory()->create([
            'name' => 'Barbeiro Pedro',
            'email' => 'pedro@barbearia.com',
        ]);

        // Cliente externo
        $client = User::factory()->create([
            'name' => 'Cliente Externo',
            'email' => 'cliente@teste.com',
        ]);

        // Atribui papéis
        $super->assignRole('super-master');
        $master->assignRole('master');
        $admin->assignRole('admin');
        $professional->assignRole('professional');
        $client->assignRole('client');

        // Permissões diretas opcionais
        $super->givePermissionTo('audit-all');
        $admin->givePermissionTo('audit-all');
        $client->givePermissionTo('youself');
    }
}
