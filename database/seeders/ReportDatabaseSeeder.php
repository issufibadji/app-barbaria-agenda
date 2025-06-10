<?php

namespace Modules\Report\Database\Seeders;

use App\Models\MenuSideBar;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class ReportDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        // MenuSideBar::create([
        //     'description' => 'Relatórios',
        //     'icon' => "fa-file-text",
        //     'module' => "report",
        //     'menu_above' => "",
        //     'level' => 0,
        //     'route' => "",
        //     'acl' => "",
        //     'order' => 5,
        //     'active' => true,
        // ]);

        // MenuSideBar::create([
        //     'description' => 'Novo Relatório',
        //     'icon' => "fa-plus",
        //     'module' => "report",
        //     'menu_above' => "Relatórios",
        //     'level' => 1,
        //     'route' => "relatorio/criar",
        //     'acl' => "report::criar-admin",
        //     'order' => 1,
        //     'active' => true,
        // ]);

        MenuSideBar::create([
            'description' => 'Listar Relatórios',
            'icon' => "fa-clipboard-list",
            'module' => "report",
            'menu_above' => "",
            'level' => 0,
            'route' => "relatorio/listar",
            'acl' => "report::listar-admin",
            'order' => 2,
            'active' => true,
        ]);

        Permission::create(['name' => 'report::listar-admin', 'module' => 'report']);
        Permission::create(['name' => 'report::criar-admin', 'module' => 'report']);
    }
}
