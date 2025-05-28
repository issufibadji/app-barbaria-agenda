<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

         $permissions = [
            'gerenciar usuários',
            'ver logs',
            'enviar notificações',
            'ver relatórios',
            'acessar pagamentos',
            'configurar sistema',
            // adicione todas as que quiser aqui
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Garantir que admin tenha todas
        $admin->syncPermissions(Permission::all());
        }
}
