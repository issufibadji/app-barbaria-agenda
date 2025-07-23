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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('model_has_permissions')->delete();
        Permission::query()->delete();
        Role::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Cria os papéis
        Role::firstOrCreate(['name' => 'super-master']);
        Role::firstOrCreate(['name' => 'master']);
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'professional']);
        Role::firstOrCreate(['name' => 'client']);

        // Lista de permissões
        $perms = [
            'permissions-all','roles-all','roles-user-all','plan-all','configs-all',
            'signature-all','user-all','audit-all','notification-all','menu-all','youself',
            'clients-all','employees-all','appointments-all','schedules-all',
            'products-all','services-all','establishments-all','messages-all',
            'addresses-all','phones-all','mensagens-settings-all','chat-link-settings-all'
        ];
        foreach ($perms as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        // Sincroniza permissões
        $all = Permission::all();
        Role::findByName('super-master')->syncPermissions($all);
        Role::findByName('master')      ->syncPermissions($all);
        Role::findByName('admin')       ->syncPermissions($all);

        Role::findByName('professional')->syncPermissions([
            'appointments-all','schedules-all','youself'
        ]);
        Role::findByName('client')->syncPermissions(['youself']);
    }
}
