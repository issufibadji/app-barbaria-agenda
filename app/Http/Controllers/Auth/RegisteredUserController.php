<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
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
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('admin');

        $slug = \Illuminate\Support\Str::slug($request->establishment_name);

        $establishment = \App\Models\AgendaAiEstablishment::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'name' => $request->establishment_name,
            'link' => 'https://agenderbarber.app/chat/' . $slug,
            'manual_chat_link' => $slug,
            'user_id' => $user->id,
        ]);

        // associate user to establishment
        $user->establishment_id = $establishment->id;
        $user->save();

        \App\Models\AgendaAiPhone::create([
            'phone' => $request->phone,
            'establishment_id' => $establishment->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('establishments.update-page');
    }
}
