<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleUserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return Inertia::render('Admin/RoleUser/Index', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function assign(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($validated['user_id']);
        $role = Role::findById($validated['role_id']);

        if (!$user->hasRole($role)) {
            $user->assignRole($role);
        }

        return back()->with('success', 'Papel atribuído ao usuário.');
    }

    public function remove(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($validated['user_id']);
        $role = Role::findById($validated['role_id']);

        if ($user->hasRole($role)) {
            $user->removeRole($role);
        }

        return back()->with('success', 'Papel removido do usuário.');
    }
}
