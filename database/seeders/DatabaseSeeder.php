<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Cria primeiro os papéis e permissões
        $this->call(RoleAndPermissionSeeder::class);

        // 2) Cria o Super Master antes de qualquer outra coisa
        $super = User::factory()->create([
            'name'              => 'Super Master',
            'email'             => 'super@agender.com',
            'password'          => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $super->assignRole('super-master');
        // Garante todas as permissões a ele:
        $super->givePermissionTo(Permission::pluck('name')->all());

        // 3) (Opcional) outros usuários de exemplo
        $master = User::factory()->create([
            'name'              => 'Master TI',
            'email'             => 'master@agender.com',
            'password'          => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $master->assignRole('master');

        $admin = User::factory()->create([
            'name'              => 'Administrador',
            'email'             => 'admin@agender.com',
            'password'          => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        $professional = User::factory()->create([
            'name'              => 'Barbeiro Pedro',
            'email'             => 'pedro@barbearia.com',
            'password'          => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $professional->assignRole('professional');

        $client = User::factory()->create([
            'name'              => 'Cliente Externo',
            'email'             => 'cliente@teste.com',
            'password'          => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $client->assignRole('client');

        // 4) (Opcional) seeders de menu, configurações, mensagens, etc.
        $this->call([
            MenuSidebarSeeder::class,
            AppConfigSeeder::class,
            MessageSettingsSeeder::class,
        ]);
    }
}
