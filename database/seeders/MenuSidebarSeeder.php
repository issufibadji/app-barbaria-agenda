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
        MenuSideBar::truncate();

        // Grupo: Público
        MenuSideBar::create([
            'description' => 'Meu Perfil',
            'icon' => 'fa-user',
            'level' => 1,
            'route' => 'profile',
            'acl' => 'yourself',
            'order' => 1,
            'active' => true,
            'style' => 'color: text-cyan-300;',
            'group' => 'Público',
        ]);

        MenuSideBar::create([
            'description' => 'Clientes',
            'icon' => 'fa-users',
            'level' => 1,
            'route' => 'clients',
            'acl' => 'clients-all',
            'order' => 2,
            'active' => true,
            'style' => 'color: text-cyan-300;',
            'group' => 'Público',
        ]);

        MenuSideBar::create([
            'description' => 'Professionais',
            'icon' => 'fa-users',
            'level' => 1,
            'route' => 'professionals',
            'acl' => 'professionals-all',
            'order' => 3,
            'active' => true,
            'style' => 'color: text-cyan-300;',
            'group' => 'Público',
        ]);

        MenuSideBar::create([
            'description' => 'Serviços',
            'icon' => 'fa-cut',
            'level' => 1,
            'route' => 'services',
            'acl' => 'services-all',
            'order' => 3,
            'active' => true,
            'style' => 'color: text-cyan-300;',
            'group' => 'Público',
        ]);
     MenuSideBar::create([
            'description' => 'Produtos',
            'icon' => 'fas fa-box',
            'level' => 1,
            'route' => 'products',
            'acl' => 'products-all',
            'order' => 6,
            'active' => true,
            'style' => 'color: text-cyan-300;',
            'group' => 'Público',
        ]);

        MenuSideBar::create([
            'description' => 'Agenda',
            'icon' => 'fa-calendar-check',
            'level' => 1,
            'route' => 'schedules',
            'acl' => 'schedule-all',
            'order' => 5,
            'active' => true,
            'style' => 'color: text-cyan-300;',
            'group' => 'Público',
        ]);
        MenuSideBar::create([
            'description' => 'Agendamentos',
            'icon' => 'fa-calendar-check',
            'level' => 1,
            'route' => 'appointments',
            'acl' => 'appointments-all',
            'order' => 4,
            'active' => true,
            'style' => 'color: text-cyan-300;',
            'group' => 'Público',
        ]);

        // Grupo: Conteúdo - Blog
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

        $blogMenus = [
            ['Listar Categorias', 'fa-boxes-stacked', 'blog/categories', 'blog-categories'],
            ['Listar Tags', 'fa-tags', 'blog/tags', 'blog-tags'],
            ['Listar Templates', 'fa-newspaper', 'blog/templates', 'blog-templates'],
            ['Listar Posts', 'fa-feather-pointed', 'blog/posts', 'blog-posts'],
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

        // Grupo: Administração
        $admin = MenuSideBar::create([
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

        $adminMenus = [
            ['Gestão de Usuários', 'fa-user-cog', 'users', 'user-all'],
            ['Assinatura', 'fa-layer-group', 'signature', 'signature-all'],
            ['Pagamentos', 'fa-credit-card', 'payments', 'payments-all'],
            ['Relatórios', 'fa-chart-line', 'reports', 'reports-all'],
            ['Estabelicimento', 'fa-house', 'house', 'establishments-all'],
        ];

        foreach ($adminMenus as $i => [$desc, $icon, $route, $acl]) {
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
                'parent_id' => $admin->id,
            ]);
        }

        // Grupo: Sistema
        $system = MenuSideBar::create([
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

        $systemMenus = [
            ['Gestão de Menus', 'fa-stream', 'menus', 'menu-all'],
            ['Gestão de Planos', 'fa-layer-group', 'plans', 'plan-all'],
            ['Gestão de Papéis', 'fa-shield-alt', 'roles', 'roles-all'],
            ['Gestão de Permissões', 'fa-lock', 'permissions', 'permissions-all'],
            ['Roles/Usuários', 'fa-user-tag', 'roles-user', 'roles-user-all'],
            ['Configurações do sistema', 'fa-cogs', 'config', 'configs-all'],
            ['Gestão de Logs', 'fa-list-alt', 'audits', 'audit-all'],
            ['Enviar notificações', 'fa-paper-plane', 'notifications/send', 'notification-all'],
        ];

        foreach ($systemMenus as $i => [$desc, $icon, $route, $acl]) {
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
                'parent_id' => $system->id,
            ]);
        }
    }
}
