<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return Inertia::render('Admin/Permissions/Index', [
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Permissions/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'module' => 'nullable|string|max:255',
        ]);

        Permission::create([
            'name' => $validated['name'],
            'module' => $validated['module'] ?? null,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permissão criada com sucesso.');
    }

    public function edit(Permission $permission)
    {
        return Inertia::render('Admin/Permissions/Edit', [
            'permission' => $permission
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'module' => 'nullable|string|max:255',
        ]);

        $permission->update([
            'name' => $validated['name'],
            'module' => $validated['module'] ?? null,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permissão atualizada.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permissão excluída.');
    }
}
