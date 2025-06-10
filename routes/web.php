<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use OwenIt\Auditing\Models\Audit;
// Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TwoFactorAuthController;
use App\Http\Controllers\MenuSideBarController;
use App\Http\Controllers\LogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PragmaRX\Google2FA\Google2FA;
use App\Http\Controllers\AuditController;

use Http\AgendaAiEstablishment;
use Http\AgendaAiPlan;
use Http\Controllers\AgendaAiPlanController;
use Http\Controllers\AgendaAiPhoneController;
use Http\Controllers\AgendaAiClientController;
use Http\Controllers\AgendaAiServiceController;
use Http\Controllers\AgendaAiPaymentController;
use Http\Controllers\AgendaAiProductController;
use Http\Controllers\AgendaAiScheduleController;
use Http\Controllers\AgendaAiEstablishmentController;
use Http\Controllers\AgendaAiProfessionalController;
use Http\Controllers\AgendaAiAppointmentController;
use Http\Controllers\AgendaAiMessageController;
use Http\Controllers\AgendaAiAddressEstablishmentController;
use Http\MercadoPayment;
use Http\Controllers\MercadoPagoController;
use Http\Request;
use App\Models\User;
use Http\AgendaAiPayment;

// Rota inicial
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Dashboard (acesso após login e e-mail verificado)
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//  rotas protegidas por 2FA
// Route::middleware(['auth', '2fa'])->group(function () {
//     Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
//     // outras rotas protegidas
// });
// Página de digitação do código 2FA
Route::get('/two-factor', function () {
    return Inertia::render('Auth/TwoFactorAuth');
})->middleware(['auth'])->name('two-factor');

// Validação do código 2FA
Route::post('/two-factor/verify', function (Request $request) {
    $request->validate([
        'code' => 'required|digits:6',
    ]);

    $user = $request->user();

    $google2fa = new Google2FA();
    $secret = Crypt::decrypt($user->google2fa_secret); // Ou outro campo secreto usado

    $isValid = $google2fa->verifyKey($secret, $request->input('code'));

    if (! $isValid) {
        return response()->json(['message' => 'Invalid code'], 422);
    }

    session(['2fa_passed' => true]);

    return response()->json(['redirect' => route('dashboard')]);
})->middleware(['auth']);

// Perfil de usuário autenticado
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/2fa/setup', [TwoFactorAuthController::class, 'show'])->name('2fa.setup');
    Route::post('/profile/2fa/enable', [TwoFactorAuthController::class, 'enable'])->name('2fa.enable');
    Route::post('/profile/2fa/disable', [TwoFactorAuthController::class, 'disable'])->name('2fa.disable');
});

// Administração (somente admin)
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Papéis (Roles)
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // Permissões
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    // Atribuição de papéis a usuários
    Route::get('/roles-user', [RoleUserController::class, 'index'])->name('roles-user.index');
    Route::post('/roles-user', [RoleUserController::class, 'assign'])->name('roles-user.assign');
    Route::delete('/roles-user', [RoleUserController::class, 'remove'])->name('roles-user.remove');

    // Usuários
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Ativar/desativar status
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Ativar/desativar 2FA
   Route::post('/users/{user}/toggle-2fa', [UserController::class, 'toggle2FA'])->name('users.toggle-2fa');

    // MenuSideBar - Gestão de Menus
    Route::get('/menus', [MenuSideBarController::class, 'index'])->name('menus.index');
    Route::get('/menus/create', [MenuSideBarController::class, 'create'])->name('menus.create');
    Route::post('/menus', [MenuSideBarController::class, 'store'])->name('menus.store');
    Route::get('/menus/{menu}/edit', [MenuSideBarController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{menu}', [MenuSideBarController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [MenuSideBarController::class, 'destroy'])->name('menus.destroy');
    // Logs
    Route::get('/audits', [AuditController::class, 'index'])->name('audits.index');
    Route::get('/audits/{audit}', [AuditController::class, 'show'])->name('audits.show');
    Route::delete('/audits/{audit}', [AuditController::class, 'destroy'])->name('audits.destroy');


    Route::prefix('mercadopago')->group(function() {
    Route::post('/process_payment', 'MercadoPagoController@processPayment');
});


   // Página inicial direcionada para serviços
   Route::get('/', [AgendaAiServiceController::class, 'index'])->name('home');

   // Rotas de serviços
   Route::resource('services', AgendaAiServiceController::class);

   // Rotas de produtos
   Route::resource('products', AgendaAiProductController::class);

   // Rotas de estabelecimentos
   Route::resource('establishments', AgendaAiEstablishmentController::class);

   // Rotas de telefones (AgendaAiPhone)
   Route::resource('phones', AgendaAiPhoneController::class);

   // Rotas de Profissionais(AgendaAiProfessional)
   Route::resource('professionals', AgendaAiProfessionalController::class);

   // Rotas de Profissionais(AgendaAiClient)
   Route::resource('clients',  AgendaAiClientController::class);

   // Rotas de Profissionais(AgendaAiAppointment)
   Route::resource('schedules', AgendaAiScheduleController::class);

   // Rotas de Profissionais(AgendaAiSchedule)
   Route::resource('appointments', AgendaAiAppointmentController::class);

   // Rotas de Profissionais(AgendaAiAddressEstablishment)
   Route::resource('addresses', AgendaAiAddressEstablishmentController::class);

   // Rotas de Profissionais(AgendaAiPlanController)
   Route::resource('plans', AgendaAiPlanController::class);

   // Rotas de Profissionais(AgendaAiPaymentController)
   Route::resource('payments', AgendaAiPaymentController::class);

   // Rotas de Profissionais(AgendaAiPaymentController)
   Route::resource('messages', AgendaAiMessageController::class);

   // Rotas de Profissionais(AgendaAiPlanController)

   // Rotas de Profissionais(AgendaAiPaymentController)
   Route::get('list-payments', [AgendaAiPaymentController::class, 'listPayments']);

   Route::get('plans-customer', [AgendaAiPlanController::class, 'indexCustomer']);

   Route::get('checkout/{plano}', [AgendaAiPaymentController::class, 'generatePayment']);

   Route::get('repayment/{id}', function ($id) {

      $payment = MercadoPayment::join('users', 'mercado_payments.id_module', '=', 'users.id')
         ->where('mercado_payments.status', 'pendente')
         ->where('users.id', Auth::user()->id)
         ->where('mercado_payments.id', $id)
         ->select('mercado_payments.*')
         ->first();

      if ($payment && ($payment->status == 'pendente' && $payment->qr_code != null && $payment->id_mp != null)) {
         return view('agendaai::agendaai_payments.payment', compact('payment'));
      } else {
         Session::flash('error', 'Pagamento Não Encontrado / Pagamento Vencido!');
         return redirect()->back();
      }
   });



Route::middleware(['auth', '2fa', 'check.email.verification'])->prefix('relatorio')->group(function () {
    Route::get('/', function () {
        // Obter todas as tabelas na base de dados
        // $tables = DB::select('SHOW TABLES');
        $tables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tables as $table) {
            // Obter informações sobre cada coluna na tabela
            // $columns = DB::select("DESCRIBE $table");
            // $tableName = reset($table);

            // Para obter comentários, você pode consultar a tabela information_schema
            $tableComments = DB::select("
                                            SELECT table_name, table_comment
                                            FROM information_schema.tables
                                            WHERE table_schema = :database AND table_name = :table
                                        ", ['database' => env('DB_DATABASE'), 'table' => $table]);

            // Obter informações sobre as chaves estrangeiras da tabela
            $foreignKeys = DB::select("
                                        SELECT
                                            table_name,
                                            column_name,
                                            referenced_table_name,
                                            referenced_column_name
                                        FROM information_schema.key_column_usage
                                        WHERE referenced_table_name IS NOT NULL
                                            AND table_name = :table
                                    ", ['table' => $table]);

            // Obter informações sobre cada coluna na tabela, incluindo comentários
            $columns = DB::select("
                        SELECT column_name, column_type, column_comment
                        FROM information_schema.columns
                        WHERE table_name = :table
                    ", ['table' => $table]);

            // Imprimir informações sobre a tabela
            echo "Tabela: $table<br>";

            // Imprimir informações sobre as colunas
            foreach ($columns as $column) {
                echo "  - Coluna: {$column->column_name}, Tipo: {$column->column_type}";
                echo !empty($column->column_comment) ? ", Comentário: {$column->column_comment}<br>" : "<br>";
            }

            // Imprimir comentários da tabela, se disponíveis
            if (!empty($tableComments[0]->table_comment)) {
                echo "  - Comentário da Tabela: {$tableComments[0]->table_comment}<br>";
            }

            // Imprimir informações sobre as chaves estrangeiras
            foreach ($foreignKeys as $foreignKey) {
                echo "  - Chave Estrangeira: {$foreignKey->column_name} em $table referencia {$foreignKey->referenced_column_name} em {$foreignKey->referenced_table_name}<br>";
            }

            echo "<br>";
        }
    });

    Route::get('/listar', [Modules\Report\Http\Controllers\ReportController::class, 'index'])->name('relatorios.index'); // Listar
    Route::get('/{uuid}/edit', [Modules\Report\Http\Controllers\ReportController::class, 'edit'])->name('relatorios.edit'); // Editar
    Route::delete('/{uuid}', [Modules\Report\Http\Controllers\ReportController::class, 'destroy'])->name('relatorios.destroy'); // Excluir

    Route::get('/criar', 'ReportController@create')->name('relatorios.create');
    Route::post('/store', 'ReportController@store')->name('relatorios.store');

    Route::post('/preview-store', 'ReportController@previewReport')->name('relatorios.preview-store');

    Route::post('/lista_tabelas_relacionadas', [Modules\Report\Http\Controllers\ReportController::class, 'listaTabelasRelacionadas']);
    Route::post('/lista_colunas_fk', 'ReportController@listaColunasFK');
    Route::post('/lista_colunas_pk', 'ReportController@listaColunasPK');
    Route::post('/lista_colunas', 'ReportController@listaColunas');

    Route::get('/renderReport/{reportUuid}',  [Modules\Report\Http\Controllers\ReportController::class, 'executeReport'])->name('relatorios.renderReport');
});
//     Route::get('/template/barbershop', function () {
//     return Inertia::render('Templates/landingpage/Barbershop');
// })->name('template.barbershop');
});

// Rota de teste de permissão
Route::get('/teste-role', function () {
    return 'Acesso autorizado para admin';
})->middleware(['auth', 'role:admin']);

    Route::get('/template/barbershop', function () {
    return Inertia::render('Templates/landingpage/Barbershop');
})->name('template.barbershop');

   Route::get('/template/LandingBarbershop', function () {
    return Inertia::render('Templates/landingpage/LandingBarbershop');
})->name('template.LandingBarbershop');

   Route::get('/template/LandingManhattan', function () {
    return Inertia::render('Templates/landingpage/LandingManhattan');
})->name('template.LandingManhattan');

   Route::get('/template/LandingNYC', function () {
    return Inertia::render('Templates/landingpage/LandingNYC');
})->name('template.LandingNYC');

   Route::get('/template/LandingPrices', function () {
    return Inertia::render('Templates/landingpage/LandingPrices');
})->name('template.LandingPrices');

   Route::get('/template/LandingBarberNY', function () {
    return Inertia::render('Templates/landingpage/LandingBarberNY');
})->name('template.LandingBarberNY');

   Route::get('/template/LandingModel', function () {
    return Inertia::render('Templates/landingpage/LandingModel');
})->name('template.LandingModel');

   Route::get('/template/LandingBlaxCut', function () {
    return Inertia::render('Templates/landingpage/LandingBlaxCut');
})->name('template.LandingBlaxCut');

   Route::get('/template/LandingBarberHtml5', function () {
    return Inertia::render('Templates/landingpage/LandingBarberHtml5');
})->name('template.LandingBarberHtml5');


   Route::get('/template/LandingBarberHouse', function () {
    return Inertia::render('Templates/landingpage/LandingBarberHouse');
})->name('template.LandingBarberHouse');


   Route::get('/template/LandingCustom', function () {
    return Inertia::render('Templates/landingpage/LandingCustom');
})->name('template.LandingCustom');


require __DIR__ . '/auth.php';
