<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\MenuSideBar;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuSideBarController extends Controller
{
    public function index()
    {
        $menus = MenuSideBar::orderBy('order')->paginate(20);
        return Inertia::render('Admin/Menus/Index', [
            'menus' => $menus,
        ]);
    }

    public function create()
    {
        $parents = MenuSideBar::orderBy('description')->get(['id', 'description']);
        return Inertia::render('Admin/Menus/Create', [
            'parents' => $parents,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'style' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menu_side_bars,id',
            'level' => 'required|integer|min:0',
            'route' => 'nullable|string|max:255',
            'acl' => 'nullable|string|max:255',
            'order' => 'required|integer',
            'active' => 'required|boolean',
            'group' => 'nullable|string|in:operacional,gestores,admin',
        ]);

        MenuSideBar::create($request->all());

        return redirect()->route('menus.index')->with('success', 'Menu criado com sucesso!');
    }

    public function edit(MenuSideBar $menu)
    {
        $parents = MenuSideBar::where('id', '!=', $menu->id)->orderBy('description')->get(['id', 'description']);
        return Inertia::render('Admin/Menus/Edit', [
            'menu' => $menu,
            'parents' => $parents,
        ]);
    }

    public function update(Request $request, MenuSideBar $menu)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'style' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menu_side_bars,id',
            'level' => 'required|integer|min:0',
            'route' => 'nullable|string|max:255',
            'acl' => 'nullable|string|max:255',
            'order' => 'required|integer',
            'active' => 'required|boolean',
            'group' => 'nullable|string|in:operacional,gestores,admin',
        ]);

        $menu->update($request->all());

        return redirect()->route('menus.index')->with('success', 'Menu atualizado com sucesso!');
    }

    public function destroy(MenuSideBar $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu excluído com sucesso!');
    }
}
