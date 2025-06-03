<?php

namespace App\Providers;

use App\Models\MenuSideBar;
use Inertia\Inertia;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

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
     *  @var \App\Models\User|null $user
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

            Inertia::share([
            'auth' => [
                'user' => Auth::check() ? [
                    'id' => Auth::id(),
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'roles' => Auth::user()->getRoleNames()->toArray(),
                    'permissions' => Auth::user()->getAllPermissions()->pluck('name')->toArray(),
                ] : null
                ],
                'sideMenus' => function () {
                return MenuSideBar::where('active', true)
                    ->orderBy('order')
                    ->get(['id', 'description', 'route', 'icon', 'parent_id', 'level']);
            }
                ]);

                // Inertia::share([
                //  'sideMenus' => fn () => MenuSideBar::all(),
                //  ]);
    }
}
