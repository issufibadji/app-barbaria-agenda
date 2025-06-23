<?php

namespace App\Providers;

use App\Models\MenuSideBar;
use Inertia\Inertia;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use OwenIt\Auditing\AuditableObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * @var \App\Models\User|null $user
     */
    public function boot(): void
    {
        User::observe(AuditableObserver::class);

        Vite::prefetch(concurrency: 3);

        Inertia::share([
            'auth' => [
                'user' => Auth::check() ? [
                    'id' => Auth::id(),
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'role' => Auth::user()->getRoleNames()->first(),
                    'roles' => Auth::user()->getRoleNames()->toArray(),
                    'permissions' => Auth::user()->getAllPermissions()->pluck('name')->toArray(),
                ] : null,
            ],
            'sideMenus' => function () {
                $user = Auth::user();

                // Verifica se o usuário tem papel válido
                if (!$user) return [];

                $roles = $user->getRoleNames()->toArray();

                $menus = MenuSideBar::where('active', true)
                    ->orderBy('order')
                    ->get(['id', 'description', 'route', 'icon', 'parent_id', 'level', 'style']);

                // Filtro por papel, se necessário
                return $menus->filter(function ($menu) use ($roles) {
                    // Oculta menus de Administração para admin e professional
                    if ($menu->level === 3 && (in_array('admin', $roles) || in_array('professional', $roles))) {
                        return false;
                    }

                    // Oculta menus de Estabelecimento para quem não for super/master
                    if (str_starts_with($menu->route, 'establishments') && !in_array('super-master', $roles) && !in_array('master', $roles)) {
                        return false;
                    }

                    return true;
                })->values();
            },
        ]);
    }
}
