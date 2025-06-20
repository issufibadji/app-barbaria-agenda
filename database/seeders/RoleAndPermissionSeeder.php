<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 🔒 Desativa checagem de chaves estrangeiras
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Limpa as tabelas com delete (mais seguro com FKs)
        DB::table('role_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('model_has_permissions')->delete();
        Permission::query()->delete();
        Role::query()->delete();

        // 🔓 Reativa checagem de chaves estrangeiras
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Criação dos papéis
        $superMaster = Role::firstOrCreate(['name' => 'super-master']); // Dono do SaaS
        $master = Role::firstOrCreate(['name' => 'master']);           // Suporte técnico/TI
        $admin = Role::firstOrCreate(['name' => 'admin']);             // Administrador da barbearia
        $professional = Role::firstOrCreate(['name' => 'professional']);// Colaborador/barbeiro
        $client = Role::firstOrCreate(['name' => 'client']);           // Usuário externo

        // Lista de permissões
        $permissions = [
            'permissions-all',
            'roles-all',
            'roles-user-all',
            'plan-all',
            'configs-all',
            'signature-all',
            'user-all',
            'audit-all',
            'notification-all',
            'menu-all',
            'youself',
            'clients-all',
            'employees-all',
            'appointments-all',
            'schedules-all',
            'products-all',
            'services-all',
            'establishments-all',
            'messages-all',
            'addresses-all',
            'phones-all',
            'mensagens-settings-all',
            'chat-link-settings-all'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Atribui permissões conforme níveis
        $allPermissions = Permission::all();
        $superMaster->syncPermissions($allPermissions);
        $master->syncPermissions($allPermissions);
        $admin->syncPermissions($allPermissions);

        // Permissões limitadas
        $professional->syncPermissions([
            'appointments-all',
            'schedules-all',
            'youself'
        ]);

        $client->syncPermissions([
            'youself'
        ]);
    }
}
