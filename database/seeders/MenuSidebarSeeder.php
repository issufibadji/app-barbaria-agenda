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
            'style' => 'color: text-emerald-300;',
            'group' => 'Público',
        ]);

        // Grupo 2: Gestão da Loja
        $gestaoLoja = MenuSideBar::create([
            'description' => 'Gestão da Loja',
            'icon' => 'fa-store',
            'level' => 1,
            'route' => null,
            'acl' => null,
            'order' => 100,
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
                'level' => 2,
                'route' => $route,
                'acl' => $acl,
                'order' => 101 + $i,
                'active' => true,
                'style' => 'color: text-sky-300;',
                'group' => 'Administração',
                'parent_id' => $gestaoLoja->id,
            ]);
        }

        // Grupo 3: Blog
        $blog = MenuSideBar::create([
            'description' => 'Gestão de Blog',
            'icon' => 'fa-blog',
            'level' => 1,
            'route' => null,
            'acl' => null,
            'order' => 150,
            'active' => true,
            'style' => 'color: text-cyan-200;',
            'group' => 'Conteúdo',
        ]);

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
                'style' => 'color: text-cyan-200;',
                'group' => 'Conteúdo',
                'parent_id' => $blog->id,
            ]);
        }

        // Grupo 4: Administração do Sistema
        $sistema = MenuSideBar::create([
            'description' => 'Administração do Sistema',
            'icon' => 'fa-tools',
            'level' => 1,
            'route' => null,
            'acl' => null,
            'order' => 200,
            'active' => true,
            'style' => 'color: text-yellow-300;',
            'group' => 'Sistema',
        ]);

        $sistemaMenus = [
            ['Gestão de Menus', 'fa-stream', 'menus', 'menu-all'],
            ['Gestão de Papéis', 'fa-shield-alt', 'roles', 'roles-all'],
            ['Gestão de Permissões', 'fa-lock', 'permissions', 'permissions-all'],
            ['Roles/Usuários', 'fa-user-tag', 'user-roles', 'user-roles-all'],
            ['Configurações do sistema', 'fa-cogs', 'config', 'configs-all'],
            ['Gestão de Logs', 'fa-list-alt', 'audit-logs', 'audit-all'],
            ['Enviar notificações', 'fa-paper-plane', 'notifications/send', 'notification-all'],
        ];

        foreach ($sistemaMenus as $i => [$desc, $icon, $route, $acl]) {
            MenuSideBar::create([
                'description' => $desc,
                'icon' => $icon,
                'level' => 2,
                'route' => $route,
                'acl' => $acl,
                'order' => 201 + $i,
                'active' => true,
                'style' => 'color: text-yellow-300;',
                'group' => 'Sistema',
                'parent_id' => $sistema->id,
            ]);
        }
    }
}
