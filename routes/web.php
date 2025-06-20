<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PragmaRX\Google2FA\Google2FA;

// Controllers
use App\Http\Controllers\{
    ProfileController,
    RoleController,
    PermissionController,
    RoleUserController,
    UserController,
    TwoFactorAuthController,
    MenuSideBarController,
    AppConfigController,
    ReportController,
    NotificationController,
    PushSubscriptionController,
    AgendaAiAddressEstablishmentController,
    AgendaAiAppointmentController,
    AgendaAiClientController,
    AgendaAiEstablishmentController,
    AgendaAiMessageController,
    AgendaAiPaymentController,
    AgendaAiPhoneController,
    AgendaAiPlanController,
    AgendaAiProductController,
    AgendaAiProfessionalController,
    AgendaAiScheduleController,
    AgendaAiServiceController,
    AuditController,
    PublicChatController,
    AgendaAiMessageSettingController,
    AgendaAiChatLinkController
};

// Home
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Dashboard
Route::get('/dashboard', fn () => Inertia::render('Dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 2FA
Route::middleware('auth')->group(function () {
    Route::get('/two-factor', fn () => Inertia::render('Auth/TwoFactorAuth'))->name('two-factor');

    Route::post('/two-factor/verify', function (Request $request) {
        $request->validate(['code' => 'required|digits:6']);
        $user = $request->user();
        $secret = Crypt::decrypt($user->google2fa_secret);
        $isValid = (new Google2FA())->verifyKey($secret, $request->input('code'));

        if (! $isValid) {
            return response()->json(['message' => 'Invalid code'], 422);
        }

        session(['2fa_passed' => true]);
        return response()->json(['redirect' => route('dashboard')]);
    });
});

// Perfil
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');

    Route::get('/2fa/setup', [TwoFactorAuthController::class, 'show'])->name('2fa.setup');
    Route::post('/2fa/enable', [TwoFactorAuthController::class, 'enable'])->name('2fa.enable');
    Route::post('/2fa/disable', [TwoFactorAuthController::class, 'disable'])->name('2fa.disable');
});

// Administração (admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Roles, Permissões, Atribuições
    Route::resource('roles', RoleController::class)->except('show');
    Route::resource('permissions', PermissionController::class)->except('show');

    Route::controller(RoleUserController::class)->prefix('roles-user')->name('roles-user.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'assign')->name('assign');
        Route::delete('/', 'remove')->name('remove');
    });

    // Usuários
    Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
        Route::post('/{user}/toggle-status', 'toggleStatus')->name('toggle-status');
        Route::post('/{user}/toggle-2fa', 'toggle2FA')->name('toggle-2fa');
    });

    // Menus
    Route::resource('menus', MenuSideBarController::class)->except('show');

    // Auditoria
    Route::controller(AuditController::class)->prefix('audits')->name('audits.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{audit}', 'show')->name('show');
        Route::delete('/{audit}', 'destroy')->name('destroy');
    });

    // Templates
    Route::prefix('template')->name('template.')->group(function () {
       Route::get('/barbershop', fn () => Inertia::render('Templates/Landingpage/Barbershop'))->name('barbershop');

        Route::get('/LandingBarbershop', fn () => Inertia::render('Templates/Landingpage/LandingBarbershop'))->name('LandingBarbershop');
        Route::get('/LandingManhattan', fn () => Inertia::render('Templates/Landingpage/LandingManhattan'))->name('LandingManhattan');
        Route::get('/LandingNYC', fn () => Inertia::render('Templates/Landingpage/LandingNYC'))->name('LandingNYC');
        Route::get('/LandingPrices', fn () => Inertia::render('Templates/Landingpage/LandingPrices'))->name('LandingPrices');
        Route::get('/LandingBarberNY', fn () => Inertia::render('Templates/Landingpage/LandingBarberNY'))->name('LandingBarberNY');
        Route::get('/LandingModel', fn () => Inertia::render('Templates/Landingpage/LandingModel'))->name('LandingModel');
        Route::get('/LandingBlaxCut', fn () => Inertia::render('Templates/Landingpage/LandingBlaxCut'))->name('LandingBlaxCut');
        Route::get('/LandingBarberHtml5', fn () => Inertia::render('Templates/Landingpage/LandingBarberHtml5'))->name('LandingBarberHtml5');
        Route::get('/LandingBarberHouse', fn () => Inertia::render('Templates/Landingpage/LandingBarberHouse'))->name('LandingBarberHouse');
        Route::get('/LandingCustom', fn () => Inertia::render('Templates/Landingpage/LandingCustom'))->name('LandingCustom');
    });
});

Route::controller(AgendaAiClientController::class)
    ->prefix('clients')
    ->name('clients.')
    ->group(function () {
        Route::get('/',   'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{client}/edit', 'edit')->name('edit');
        Route::put('/{client}',      'update')->name('update');
        Route::delete('/{client}',   'destroy')->name('destroy');
});


Route::controller(AgendaAiProfessionalController::class)
    ->prefix('professionals')
    ->name('professionals.')
    ->group(function () {
        Route::get('/',   'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{professional}/edit', 'edit')->name('edit');
        Route::put('/{professional}',      'update')->name('update');
        Route::delete('/{professional}',   'destroy')->name('destroy');
});

Route::controller(AgendaAiPhoneController::class)
    ->prefix('phones')
    ->name('phones.')
    ->group(function () {
        Route::get('/',   'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{phone}/edit', 'edit')->name('edit');
        Route::put('/{phone}',      'update')->name('update');
        Route::delete('/{phone}',   'destroy')->name('destroy');
});


Route::controller(AgendaAiAddressEstablishmentController::class)
    ->prefix('addresses')
    ->name('addresses.')
    ->group(function () {
        Route::get('/',   'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{address}/edit', 'edit')->name('edit');
        Route::put('/{address}',      'update')->name('update');
        Route::delete('/{address}',   'destroy')->name('destroy');
});

Route::controller(AgendaAiServiceController::class)
    ->prefix('services')
    ->name('services.')
    ->group(function () {
        Route::get('/',   'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{service}/edit', 'edit')->name('edit');
        Route::put('/{service}',      'update')->name('update');
        Route::delete('/{service}',   'destroy')->name('destroy');
});

Route::controller(AgendaAiProductController::class)
    ->prefix('products')
    ->name('products.')
    ->group(function () {
        Route::get('/',   'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{product}/edit', 'edit')->name('edit');
        Route::put('/{product}',      'update')->name('update');
        Route::delete('/{product}',   'destroy')->name('destroy');
});

Route::controller(AgendaAiScheduleController::class)
    ->prefix('schedules')
    ->name('schedules.')
    ->group(function () {
        Route::get('/',   'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{schedule}/edit', 'edit')->name('edit');
        Route::put('/{schedule}',      'update')->name('update');
        Route::delete('/{schedule}',   'destroy')->name('destroy');
});

Route::controller(AgendaAiAppointmentController::class)
    ->prefix('appointments')
    ->name('appointments.')
    ->group(function () {
        Route::get('/',   'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{appointment}/edit', 'edit')->name('edit');
        Route::put('/{appointment}',      'update')->name('update');
        Route::delete('/{appointment}',   'destroy')->name('destroy');
});

Route::controller(AgendaAiEstablishmentController::class)
    ->prefix('establishments')
    ->name('establishments.')
    ->group(function () {
        Route::get('/',   'index')->name('index');
        Route::get('/update', 'editCurrent')->name('update-page');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{establishment}/edit', 'edit')->name('edit');
        Route::put('/{establishment}',      'update')->name('update');
        Route::delete('/{establishment}',   'destroy')->name('destroy');
});

Route::controller(AgendaAiMessageController::class)
    ->prefix('messages')
    ->name('messages.')
    ->group(function () {
        Route::get('/',   'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{message}/edit', 'edit')->name('edit');
        Route::put('/{message}',      'update')->name('update');
        Route::delete('/{message}',   'destroy')->name('destroy');
        Route::post('bulk-update', 'bulkUpdate')->name('messages.bulk-update');


});

Route::get('/messages/settings', [AgendaAiMessageSettingController::class, 'index'])->name('messages.settings');
Route::post('/messages/settings', [AgendaAiMessageSettingController::class, 'update'])->name('messages.settings.update');
Route::get('/settings/chat-link', [AgendaAiChatLinkController::class, 'edit'])->name('settings.chat-link.edit');
Route::post('/settings/chat-link', [AgendaAiChatLinkController::class, 'update'])->name('settings.chat-link.update');


Route::controller(AgendaAiPlanController::class)
    ->prefix('plans')
    ->name('plans.')
    ->group(function () {
        Route::get('/',   'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{plan}/edit', 'edit')->name('edit');
        Route::put('/{plan}',      'update')->name('update');
        Route::delete('/{plan}',   'destroy')->name('destroy');
});


Route::controller(AgendaAiPaymentController::class)
    ->prefix('payments')
    ->name('payments.')
    ->group(function () {
        Route::get('/',   'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/',  'store')->name('store');
        Route::get('/{payment}/edit', 'edit')->name('edit');
        Route::put('/{payment}',      'update')->name('update');
        Route::delete('/{payment}',   'destroy')->name('destroy');
        Route::get('payments/list', [AgendaAiPaymentController::class, 'listPayments'])->name('payments.list');
        Route::get('payments/generate/{plano}', [AgendaAiPaymentController::class, 'generatePayment'])->name('payments.generate');
        Route::get('plans/customer', [AgendaAiPlanController::class, 'indexCustomer'])->name('plans.customer');
    });

// Configurações e Relatórios
Route::middleware('auth')->group(function () {
    Route::resource('config', AppConfigController::class);
    Route::resource('relatorios', ReportController::class);

    Route::post('relatorios/preview', [ReportController::class, 'previewReport'])->name('relatorios.preview');
    Route::post('relatorios/related-tables', [ReportController::class, 'listaTabelasRelacionadas'])->name('relatorios.relatedTables');
    Route::post('relatorios/columns-fk', [ReportController::class, 'listaColunasFK'])->name('relatorios.columnsFk');
    Route::post('relatorios/columns-pk', [ReportController::class, 'listaColunasPK'])->name('relatorios.columnsPk');
    Route::post('relatorios/columns', [ReportController::class, 'listaColunas'])->name('relatorios.columns');
    Route::get('relatorios/render/{reportUuid}', [ReportController::class, 'executeReport'])->name('relatorios.renderReport');

    Route::post('notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::get('notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('notifications/send', [NotificationController::class, 'send'])->name('notifications.send');

    Route::post('push-subscriptions', [PushSubscriptionController::class, 'store'])->name('push-subscriptions.store');
});


Route::get('/public/{establishment:uuid}/services', [\App\Http\Controllers\PublicChatController::class, 'services']);
Route::get('/public/{establishment:uuid}/messages', [\App\Http\Controllers\PublicChatController::class, 'messages']);
Route::get('/{slug}', [\App\Http\Controllers\PublicChatController::class, 'show'])->name('chat.show');

require __DIR__ . '/auth.php';
