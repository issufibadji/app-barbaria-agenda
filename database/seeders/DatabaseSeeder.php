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
        ]);

        // Usuário comum
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Usuário admin
        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
        ]);

        // Atribui papéis
        $admin->assignRole('admin');
        $user->assignRole('user');

        // Atribui permissões diretas (opcional, além dos papéis)
        $admin->givePermissionTo('audit-all');
        $user->givePermissionTo('notification-all');
    }
}
