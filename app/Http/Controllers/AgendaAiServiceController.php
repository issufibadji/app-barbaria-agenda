<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\AgendaAiService;
use App\Models\AgendaAiProfessional;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AgendaAiServiceController extends Controller
{
    public function index()
    {
        $services = AgendaAiService::orderBy('created_at', 'desc')->get();
        return Inertia::render('Services/Index', [
            'services' => $services,
        ]);
    }

    public function create()
    {
        $professionals = AgendaAiProfessional::with('user')
            ->get()
            ->pluck('user.name', 'id');

        // instancia vazia para o partial
        $service = new AgendaAiService();

        return Inertia::render('Services/Create', [
            'professionals' => $professionals,
            'service' => $service,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'duration_min'   => 'required|integer|min:1',
            'price'          => 'required|numeric|min:0',
            'descrition'     => 'required|string|max:1000',
            'image'          => 'nullable|image|max:2048',
            'professionals'  => 'nullable|array',
            'professionals.*'=> 'exists:agendaai_professionals,id',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images','public');
        }

        $validated['user_id'] = auth()->id();
        $service = AgendaAiService::create($validated);

        // Garantir que a coluna autoincremento "id" esteja carregada
        $service->refresh();

        // sincroniza o pivot usando o id numérico que agora existe
        $service->professionals()->sync($validated['professionals'] ?? []);

        return redirect()
            ->route('services.index')
            ->with('success','Serviço criado com sucesso.');
    }

    public function edit(string $uuid)
    {
        $service = AgendaAiService::findOrFail($uuid);

        $professionals = AgendaAiProfessional::with('user')
            ->get()
            ->pluck('user.name', 'id');

        return Inertia::render('Services/Edit', [
            'service' => $service,
            'professionals' => $professionals,
        ]);
    }

    public function update(Request $request, string $uuid): RedirectResponse
    {
        $service = AgendaAiService::findOrFail($uuid);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'duration_min'   => 'required|integer|min:1',
            'price'          => 'required|numeric|min:0',
            'descrition'     => 'required|string|max:1000',
            'image'          => 'nullable|image|max:2048',
            'professionals'  => 'nullable|array',
            'professionals.*'=> 'exists:agendaai_professionals,id',
        ]);

        // Se veio nova imagem, armazene e sobrescreva no array
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images','public');
        }

        // Atualiza o próprio serviço
        $service->update($validated);

        // Sincroniza o pivot (agora $service já é o registro existente)
        $service->professionals()->sync($validated['professionals'] ?? []);

        return redirect()
            ->route('services.index')
            ->with('success', 'Serviço atualizado com sucesso.');
    }


    public function destroy(string $uuid): RedirectResponse
    {
        $service = AgendaAiService::findOrFail($uuid);

        // opcional, limpa o pivot antes de deletar
        $service->professionals()->detach();

        $service->delete();

        return redirect()
            ->route('services.index')
            ->with('success', 'Serviço excluído com sucesso.');
    }
}
