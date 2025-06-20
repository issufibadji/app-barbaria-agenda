<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AgendaAiEstablishment;
use App\Models\AgendaAiPhone;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Exibe a tela de registro.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Processa o cadastro de um novo usuário administrador e cria o estabelecimento vinculado.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'establishment_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('admin');

        $slug = Str::slug($request->establishment_name);

         $establishment = AgendaAiEstablishment::create([
            'uuid'              => (string) Str::uuid(),
            'name'              => $request->establishment_name,
            'link'              => 'https://agenderbarber.app/chat/' . $slug,
            'manual_chat_link'  => $slug,
            'user_id'           => $user->id,
        ]);

        $establishment->refresh(); // 🔧 garante que $establishment->uuid está carregado corretamente


        // Relaciona o usuário ao estabelecimento
        $user->establishment_id = $establishment->id;
        $user->save();

        // Cria telefone vinculado
        AgendaAiPhone::create([
            'telefone'          => $request->phone, // CORRIGIDO: o nome do campo na migration é "telefone", não "phone"
            'establishment_id' => $establishment->id,
            'professional_id'   => null,
        ]);

        event(new Registered($user));
        Auth::login($user);

        // Redireciona para a tela de edição do estabelecimento para completar os dados
       return redirect()->route('establishments.edit', $establishment->uuid)
         ->with('success', 'Cadastro concluído! Complete os dados do seu estabelecimento.');

    }
}
