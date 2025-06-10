<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\AgendaAiEstablishment;
use Inertia\Inertia;

class AgendaAiEstablishmentController extends Controller
{
    /**
     * Lista todos os estabelecimentos.
     */
    public function index()
    {
        if (!Auth::user()->can('agendaai::listar-establishments')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        } 
        
        $establishments = AgendaAiEstablishment::orderBy('created_at', 'desc')->get();
        return Inertia::render('Agenda/Establishments/Index', [
            'establishments' => $establishments,
        ]);
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        return Inertia::render('Agenda/Establishments/Create');
    }

    /**
     * Armazena novo estabelecimento.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url|max:255',
            'descrition' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $validated;
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        AgendaAiEstablishment::create($data);

        return redirect()->route('agendaai.establishments.index')
                         ->with('success', 'Estabelecimento criado com sucesso.');
    }

    /**
     * Exibe um estabelecimento específico.
     */
    public function show(string $uuid)
    {
        $establishment = AgendaAiEstablishment::findOrFail($uuid);
        return Inertia::render('Agenda/Establishments/Edit', [
            'establishment' => $establishment,
            'mode' => 'show'
        ]);
    }

    /**
     * Formulário de edição.
     */
    public function edit(string $uuid)
    {
        $establishment = AgendaAiEstablishment::findOrFail($uuid);
        return Inertia::render('Agenda/Establishments/Edit', [
            'establishment' => $establishment,
        ]);
    }

    /**
     * Atualiza um estabelecimento.
     */
    public function update(Request $request, string $uuid): RedirectResponse
    {
        $establishment = AgendaAiEstablishment::findOrFail($uuid);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url|max:255',
            'descrition' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $establishment->update($data);

        return redirect()->route('agendaai.establishments.index')
                         ->with('success', 'Estabelecimento atualizado com sucesso.');
    }

    /**
     * Remove o estabelecimento.
     */
    public function destroy(string $uuid): RedirectResponse
    {
        $establishment = AgendaAiEstablishment::findOrFail($uuid);
        $establishment->delete();

        return redirect()->route('agendaai.establishments.index')
                         ->with('success', 'Estabelecimento excluído com sucesso.');
    }
}
