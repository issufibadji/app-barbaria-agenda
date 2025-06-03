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
            'icon' => 'fa-user-team',
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
            'description' => 'Agendamentos',
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
            ['Gestão de Logs', 'fa-list-alt', 'audit-logs', 'audit-all'],
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
    }
}
