<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('user-roles-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        return Inertia::render('Admin/Roles/Index', [
            'roles' => Role::with('permissions')->get(),
        ]);
    }

    public function create()
    {
        if (!Auth::user()->can('user-roles-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        return Inertia::render('Admin/Roles/Create', [
            'permissions' => Permission::all(),
        ]);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('user-roles-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $data = $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Papel criado com sucesso.');
    }

    public function edit(Role $role)
    {
        if (!Auth::user()->can('user-roles-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        return Inertia::render('Admin/Roles/Edit', [
            'role' => $role->load('permissions'),
            'permissions' => Permission::all(),
        ]);
    }

    public function update(Request $request, Role $role)
    {
        if (!Auth::user()->can('user-roles-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $data = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('roles.index')->with('success', 'Papel atualizado com sucesso.');
    }

    public function destroy(Role $role)
    {
        if (!Auth::user()->can('user-roles-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Papel excluído com sucesso.');
    }
}
