<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\MenuSideBar;

class MenuSidebarSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        // 🔁 Limpa os dados antes de popular
        MenuSideBar::truncate();

        // Grupo 1: Perfil
        $perfil = MenuSideBar::create([
            'description' => 'Meu Perfil',
            'icon' => 'fa-user',
            'level' => 1,
            'route' => 'profile',
            'acl' => 'youself',
            'order' => 1,
            'active' => true,
            'style' => 'color: text-cyan-300;',
            'group' => 'Público',
        ]);

        // Grupo 1: Perfil
        $user = MenuSideBar::create([
            'description' => 'Clientes',
            'icon' => 'fa-users',
            'level' => 1,
            'route' => 'users',
            'acl' => 'youself',
            'order' => 1,
            'active' => true,
            'style' => 'color: text-cyan-300;',
            'group' => 'Público',
        ]);

        $user = MenuSideBar::create([
            'description' => 'Funcionário',
            'icon' => 'fa-users',
            'level' => 1,
            'route' => 'users',
            'acl' => 'youself',
            'order' => 1,
            'active' => true,
            'style' => 'color: text-cyan-300;',
            'group' => 'Público',
        ]);
       // Dropdown de Agendas
        $schedule = MenuSideBar::create([
            'description' => 'Agendamentos',
            'icon' => 'fa-calendar-check',
            'level' => 1,
            'route' => 'Appointments',
            'acl' => 'Appointments-all',
            'order' => 1,
            'active' => true,
            'style' => 'color: text-cyan-300;',
            'group' => 'Público',
        ]);

         $schedule = MenuSideBar::create([
            'description' => 'Agenda',
            'icon' => 'fa-calendar-check',
            'level' => 1,
            'route' => 'schedule',
            'acl' => 'schedule-all',
            'order' => 1,
            'active' => true,
            'style' => 'color: text-cyan-300;',
            'group' => 'Público',
        ]);
        $product = MenuSideBar::create([
            'description' => 'Produtos',
            'icon' => 'fas fa-box ',
            'level' => 1,
            'route' => 'products',
            'acl' => 'products-all',
            'order' => 1,
            'active' => true,
            'style' => 'color: text-cyan-300;',
            'group' => 'Público',
        ]);

        // Grupo 2: Blog
        $blog = MenuSideBar::create([
            'description' => 'Gestão de Blog',
            'icon' => 'fa-blog',
            'level' => 2,
            'route' => null,
            'acl' => null,
            'order' => 150,
            'active' => true,
            'style' => 'color: text-emerald-200;',
            'group' => 'Conteúdo',
        ]);
        // Dropdown de Gestão de Blog
        $blogMenus = [
            ['Listar Categorias', 'fa-boxes-stacked', 'blog/categories', 'blog::categorias'],
            ['Listar Tags', 'fa-tags', 'blog/tags', 'blog::tags'],
            ['Listar Templates', 'fa-newspaper', 'blog/templates', 'blog::templates'],
            ['Listar Posts', 'fa-feather-pointed', 'blog/posts', 'blog::post'],
        ];

        foreach ($blogMenus as $i => [$desc, $icon, $route, $acl]) {
            MenuSideBar::create([
                'description' => $desc,
                'icon' => $icon,
                'level' => 2,
                'route' => $route,
                'acl' => $acl,
                'order' => 151 + $i,
                'active' => true,
                'style' => 'color: text-emerald-200;',
                'group' => 'Conteúdo',
                'parent_id' => $blog->id,
            ]);
        }

        // Grupo 3: Gestão da Loja
        $gestaoLoja = MenuSideBar::create([
            'description' => 'Gestão da Loja',
            'icon' => 'fa-store',
            'level' => 3,
            'route' => null,
            'acl' => null,
            'order' => 300,
            'active' => true,
            'style' => 'color: text-sky-300;',
            'group' => 'Administração',
        ]);

        $lojaMenus = [
            ['Gestão de Usuários', 'fa-user-cog', 'users', 'user-all'],
            ['Assinatura', 'fa-layer-group', 'signature', 'signature-all'],
            ['Pagamentos', 'fa-credit-card', 'Payments', 'Payments-all'],
            ['Relatórios', 'fa-chart-line', 'Reports', 'Reports-all'],
        ];

        foreach ($lojaMenus as $i => [$desc, $icon, $route, $acl]) {
            MenuSideBar::create([
                'description' => $desc,
                'icon' => $icon,
                'level' => 3,
                'route' => $route,
                'acl' => $acl,
                'order' => 301 + $i,
                'active' => true,
                'style' => 'color: text-sky-300;',
                'group' => 'Administração',
                'parent_id' => $gestaoLoja->id,
            ]);
        }

        // Grupo 4: Administração do Sistema
        $sistema = MenuSideBar::create([
            'description' => 'Administração do Sistema',
            'icon' => 'fa-tools',
            'level' => 4,
            'route' => null,
            'acl' => null,
            'order' => 400,
            'active' => true,
            'style' => 'color: text-yellow-300;',
            'group' => 'Sistema',
        ]);

        $sistemaMenus = [
            ['Gestão de Menus', 'fa-stream', 'menus', 'menu-all'],
            ['Gestão de Planos', 'fa-layer-group', 'roles', 'plan-all'],
            ['Gestão de Papéis', 'fa-shield-alt', 'roles', 'roles-all'],
            ['Gestão de Permissões', 'fa-lock', 'permissions', 'permissions-all'],
            ['Roles/Usuários', 'fa-user-tag', 'roles-user', 'roles-user-all'],
            ['Configurações do sistema', 'fa-cogs', 'config', 'configs-all'],
            ['Gestão de Logs', 'fa-list-alt', 'audits', 'audit-all'],
            ['Enviar notificações', 'fa-paper-plane', 'notifications/send', 'notification-all'],
        ];

        foreach ($sistemaMenus as $i => [$desc, $icon, $route, $acl]) {
            MenuSideBar::create([
                'description' => $desc,
                'icon' => $icon,
                'level' => 4,
                'route' => $route,
                'acl' => $acl,
                'order' => 401 + $i,
                'active' => true,
                'style' => 'color: text-yellow-300;',
                'group' => 'Sistema',
                'parent_id' => $sistema->id,
            ]);
        }

           // --- itens de menu e permissões ---
        //Serviços
        MenuSideBar::create([
            'description' => 'Serviços',
            'icon'        => 'fa-clipboard-list',
            'module'      => 'agendaai',
            'menu_above'  => '',
            'level'       => 0,
            'route'       => 'agendaai/services',
            'acl'         => 'agendaai::listar-services',
            'order'       => 2,
            'active'      => true,
            'style' => 'color: 	lightcyan;',
        ]);
        Permission::create(['name' => 'agendaai::listar-services',      'module' => 'agendaai']);
        //--- Estabelecimentos
        MenuSideBar::create([
            'description' => 'Estabelecimentos',
            'icon'        => 'fa-house',
            'module'      => 'agendaai',
            'menu_above'  => '',
            'level'       => 0,
            'route'       => 'agendaai/establishments',
            'acl'         => 'agendaai::listar-establishments',
            'order'       => 1,
            'active'      => true,
            'style' => 'color: 	lightcyan;',
        ]);
        Permission::create(['name' => 'agendaai::listar-establishments', 'module' => 'agendaai']);



        // Produtos
        MenuSideBar::create([
            'description' => 'Produtos',
            'icon'        => 'fa-box-open',
            'module'      => 'agendaai',
            'menu_above'  => '',
            'level'       => 0,
            'route'       => 'agendaai/products',
            'acl'         => 'agendaai::listar-products',
            'order'       => 3,
            'active'      => true,
            'style' => 'color: 	lightcyan;',
        ]);
        Permission::create(['name' => 'agendaai::listar-products',     'module' => 'agendaai']);

        // Agendas (Schedules)
        MenuSideBar::create([
            'description' => 'Agendas',
            'icon'        => 'fa-calendar-alt',
            'module'      => 'agendaai',
            'menu_above'  => '',
            'level'       => 0,
            'route'       => 'agendaai/schedules',
            'acl'         => 'agendaai::listar-schedules',
            'order'       => 4,
            'active'      => true,
            'style' => 'color: 	lightcyan;',
        ]);
        Permission::create(['name' => 'agendaai::listar-schedules',    'module' => 'agendaai']);

        // Telefones
        MenuSideBar::create([
            'description' => 'Telefones',
            'icon'        => 'fa-phone',
            'module'      => 'agendaai',
            'menu_above'  => '',
            'level'       => 0,
            'route'       => 'agendaai/phones',
            'acl'         => 'agendaai::listar-phones',
            'order'       => 5,
            'active'      => true,
            'style' => 'color: 	lightcyan;',
        ]);
        Permission::create(['name' => 'agendaai::listar-phones',       'module' => 'agendaai']);

        // Profissionais
        MenuSideBar::create([
            'description' => 'Profissionais',
            'icon'        => 'fa-users',
            'module'      => 'agendaai',
            'menu_above'  => '',
            'level'       => 0,
            'route'       => 'agendaai/professionals',
            'acl'         => 'agendaai::listar-professionals',
            'order'       => 6,
            'active'      => true,
            'style' => 'color: 	lightcyan;',
        ]);
        Permission::create(['name' => 'agendaai::listar-professionals','module' => 'agendaai']);

        // Clientes
        MenuSideBar::create([
            'description' => 'Clientes',
            'icon'        => 'fa-user-friends',
            'module'      => 'agendaai',
            'menu_above'  => '',
            'level'       => 0,
            'route'       => 'agendaai/clients',
            'acl'         => 'agendaai::listar-clients',
            'order'       => 7,
            'active'      => true,
            'style' => 'color: 	lightcyan;',
        ]);
        Permission::create(['name' => 'agendaai::listar-clients',      'module' => 'agendaai']);

        // Agendamentos (Appointments)
        MenuSideBar::create([
            'description' => 'Agendamentos',
            'icon'        => 'fa-calendar-check',
            'module'      => 'agendaai',
            'menu_above'  => '',
            'level'       => 0,
            'route'       => 'agendaai/appointments',
            'acl'         => 'agendaai::listar-appointments',
            'order'       => 8,
            'active'      => true,
            'style' => 'color: 	lightcyan;',
        ]);
        Permission::create(['name' => 'agendaai::listar-appointments','module' => 'agendaai']);

        // Endereços
        MenuSideBar::create([
            'description' => 'Endereços',
            'icon'        => 'fa-map-marker-alt',
            'module'      => 'agendaai',
            'menu_above'  => '',
            'level'       => 0,
            'route'       => 'agendaai/addresses',
            'acl'         => 'agendaai::listar-addresses',
            'order'       => 9,
            'active'      => true,
            'style' => 'color: 	lightcyan;',
        ]);
        Permission::create(['name' => 'agendaai::listar-addresses',    'module' => 'agendaai']);

        // Planos
        MenuSideBar::create([
            'description' => 'Planos',
            'icon'        => 'fa-file-alt',
            'module'      => 'agendaai',
            'menu_above'  => '',
            'level'       => 0,
            'route'       => 'agendaai/plans',
            'acl'         => 'agendaai::listar-plans',
            'order'       => 55,
            'active'      => true,
            'style' => 'color: 	red;',
        ]);

        MenuSideBar::create([
            'description' => 'Planos',
            'icon'        => 'fa-file-alt',
            'module'      => 'agendaai',
            'menu_above'  => '',
            'level'       => 0,
            'route'       => 'agendaai/plans-customer',
            'acl'         => 'agendaai::listar-plans-customer',
            'order'       => 10,
            'active'      => true,
            'style' => 'color: 	lightcyan;',
        ]);
        Permission::create(['name' => 'agendaai::listar-plans',       'module' => 'agendaai']);
        Permission::create(['name' => 'agendaai::listar-plans-customer',       'module' => 'agendaai']);


        // Pagamentos
        MenuSideBar::create([
            'description' => 'Pagamentos',
            'icon'        => 'fa-credit-card',
            'module'      => 'agendaai',
            'menu_above'  => '',
            'level'       => 0,
            'route'       => 'agendaai/payments',
            'acl'         => 'agendaai::listar-payments',
            'order'       => 56,
            'active'      => true,
            'style' => 'color: red;',
        ]);
        Permission::create(['name' => 'agendaai::listar-payments',    'module' => 'agendaai']);

        // Mensagens
        MenuSideBar::create([
            'description' => 'Mensagens',
            'icon'        => 'fa-comments',
            'module'      => 'agendaai',
            'menu_above'  => '',
            'level'       => 0,
            'route'       => 'agendaai/messages',
            'acl'         => 'agendaai::listar-messages',
            'order'       => 12,
            'active'      => true,
            'style' => 'color: 	lightcyan;',
        ]);
        Permission::create(['name' => 'agendaai::listar-messages',    'module' => 'agendaai']);
    }
}
