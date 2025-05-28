
##   permissões e papéis (roles)

- ✅ Adicionar permissões
url: https://spatie.be/docs

comandos usados:
1-composer require spatie/laravel-permission
2- php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
3- php artisan optimize:clear 
# or
 php artisan config:clear

4-php artisan migrate:fresh

5-
User.php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
}

 # papéis (roles)
1-php artisan make:seeder RoleAndPermissionSeeder
RoleAndPermissionSeeder.php:
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

public function run()
{
    $admin = Role::create(['name' => 'admin']);
    $user = Role::create(['name' => 'user']);

    $permissions = ['gerenciar usuários', 'ver logs', 'enviar notificações'];

    foreach ($permissions as $perm) {
        $permission = Permission::create(['name' => $perm]);
        $admin->givePermissionTo($permission);
    }
}

2-php artisan db:seed --class=RoleAndPermissionSeeder

3-php artisan make:controller RoleController
4-php artisan make:controller PermissionController

5-RoleController.php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;

public function index()
{
    return Inertia::render('Roles/Index', [
        'roles' => Role::with('permissions')->get(),
        'permissions' => Permission::all()
    ]);
}

6-routes/web.php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
});

- ✅ Usar Tailwind plugins como forms, typography, etc.
