<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'filters' => $request->only('search'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Users/Create', [
            'roles' => Role::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'status' => 'required|in:active,inactive',
            'two_factor_enabled' => 'boolean',
            'email_verified_at' => 'nullable|date',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'two_factor_enabled' => $request->two_factor_enabled ?? false,
            'email_verified_at' => $request->email_verified_at,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso.');
    }


    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
            'roles' => Role::all(),
            'user_roles' => $user->roles->pluck('name'),
        ]);
    }

   public function update(Request $request, User $user)
   {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'password' => 'nullable|confirmed|min:6',
            'status' => 'required|in:active,inactive',
            'two_factor_enabled' => 'boolean',
            'email_verified_at' => 'nullable|date',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'two_factor_enabled' => $request->two_factor_enabled ?? false,
            'email_verified_at' => $request->email_verified_at,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuário removido com sucesso.');
    }

    public function toggleStatus(User $user)
    {
        $user->active = !$user->active;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Status do usuário atualizado.');
    }



    public function toggle2FA(User $user)
    {
        $user->active_2fa = !$user->active_2fa;
        $user->save();

        return redirect()->back()->with('success', 'Status de autenticação em 2FA atualizado com sucesso.');
    }


    }
