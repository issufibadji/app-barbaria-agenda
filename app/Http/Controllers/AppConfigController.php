<?php

namespace App\Http\Controllers;

use App\Models\AppConfig;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AppConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:configs-all');
    }

    public function index()
    {
        $configs = AppConfig::all();
        return Inertia::render('Config/Index', [
            'configs' => $configs,
        ]);
    }

    public function create()
    {
        return Inertia::render('Config/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'key'   => 'required|string|unique:app_configs,key',
            'value' => 'nullable|string',
        ]);

        AppConfig::create($data);

        return redirect()
            ->route('config.index')
            ->with('success', 'Configuração criada com sucesso.');
    }

    public function edit(AppConfig $config)
    {
        return Inertia::render('Config/Edit', [
            'config' => $config,
        ]);
    }

    public function update(Request $request, AppConfig $config): RedirectResponse
    {
        $data = $request->validate([
            'key'   => "required|string|unique:app_configs,key,{$config->id}",
            'value' => 'nullable|string',
        ]);

        $config->update($data);

        return redirect()
            ->route('config.index')
            ->with('success', 'Configuração atualizada com sucesso.');
    }

    public function destroy(AppConfig $config): RedirectResponse
    {
        $config->delete();

        return redirect()
            ->route('config.index')
            ->with('success', 'Configuração excluída com sucesso.');
    }
}
