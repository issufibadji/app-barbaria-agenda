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
    AuditController
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
        Route::get('/barbershop', fn () => Inertia::render('Templates/landingpage/Barbershop'))->name('barbershop');
        Route::get('/LandingBarbershop', fn () => Inertia::render('Templates/landingpage/LandingBarbershop'))->name('LandingBarbershop');
        Route::get('/LandingManhattan', fn () => Inertia::render('Templates/landingpage/LandingManhattan'))->name('LandingManhattan');
        Route::get('/LandingNYC', fn () => Inertia::render('Templates/landingpage/LandingNYC'))->name('LandingNYC');
        Route::get('/LandingPrices', fn () => Inertia::render('Templates/landingpage/LandingPrices'))->name('LandingPrices');
        Route::get('/LandingBarberNY', fn () => Inertia::render('Templates/landingpage/LandingBarberNY'))->name('LandingBarberNY');
        Route::get('/LandingModel', fn () => Inertia::render('Templates/landingpage/LandingModel'))->name('LandingModel');
        Route::get('/LandingBlaxCut', fn () => Inertia::render('Templates/landingpage/LandingBlaxCut'))->name('LandingBlaxCut');
        Route::get('/LandingBarberHtml5', fn () => Inertia::render('Templates/landingpage/LandingBarberHtml5'))->name('LandingBarberHtml5');
        Route::get('/LandingBarberHouse', fn () => Inertia::render('Templates/landingpage/LandingBarberHouse'))->name('LandingBarberHouse');
        Route::get('/LandingCustom', fn () => Inertia::render('Templates/landingpage/LandingCustom'))->name('LandingCustom');
    });
});

// AgendaAi - Módulo principal
Route::middleware('auth')->prefix('agendaai')->name('agendaai.')->group(function () {
    Route::resources([
        'addresses' => AgendaAiAddressEstablishmentController::class,
        'appointments' => AgendaAiAppointmentController::class,
        'clients' => AgendaAiClientController::class,
        'establishments' => AgendaAiEstablishmentController::class,
        'messages' => AgendaAiMessageController::class,
        'payments' => AgendaAiPaymentController::class,
        'phones' => AgendaAiPhoneController::class,
        'plans' => AgendaAiPlanController::class,
        'products' => AgendaAiProductController::class,
        'professionals' => AgendaAiProfessionalController::class,
        'schedules' => AgendaAiScheduleController::class,
        'services' => AgendaAiServiceController::class,
    ]);

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

require __DIR__ . '/auth.php';
