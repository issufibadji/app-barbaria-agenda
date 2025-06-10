<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('user-roles-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $permissions = Permission::all();
        return Inertia::render('Admin/Permissions/Index', [
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        if (!Auth::user()->can('user-roles-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        return Inertia::render('Admin/Permissions/Create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('user-roles-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permissão criada com sucesso.');
    }

    public function edit(Permission $permission)
    {
        if (!Auth::user()->can('user-roles-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        return Inertia::render('Admin/Permissions/Edit', [
            'permission' => $permission
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        if (!Auth::user()->can('user-roles-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permissão atualizada.');
    }

    public function destroy(Permission $permission)
    {
        if (!Auth::user()->can('user-roles-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permissão excluída.');
    }
}
