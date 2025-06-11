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
        $master = Role::firstOrCreate(['name' => 'master']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // Lista de permissões
        $permissions = [
            'permissions-all',
            'roles-all',
            'roles-user-all',
            'configs-all',
            'user-all',
            'audit-all',
            'notification-all',
            'menu-all',
            'youself',
            'clients-all',
            'employees-all',
            'appointments-all',
            'schedule-all',
            'products-all',
            'services-all',
            'establishments-all'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Atribui todas as permissões aos papéis
        $allPermissions = Permission::all();
        $admin->syncPermissions($allPermissions);
        $master->syncPermissions($allPermissions);
    }
}
