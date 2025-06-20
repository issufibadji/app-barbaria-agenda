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
        $user = Auth::user();
        $query = AgendaAiEstablishment::orderBy('created_at', 'desc');

        if ($user->hasRole('master')) {
            $query->where('user_id', $user->id);
        }

        if ($user->hasAnyRole(['admin', 'professional'])) {
            $query->where('id', $user->establishment_id);
        }

        $establishments = $query->paginate(10);

        return Inertia::render('Establishments/Index', [
            'establishments' => $establishments,
        ]);
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        return Inertia::render('Establishments/Create');
    }

    /**
     * Armazena novo estabelecimento.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url|max:255',
            'manual_chat_link' => 'nullable|string|max:255|unique:agendaai_establishments,manual_chat_link',
            'descrition' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $validated;
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        AgendaAiEstablishment::create($data);

        return redirect()->route('establishments.index')
                         ->with('success', 'Estabelecimento criado com sucesso.');
    }

    /**
     * Exibe um estabelecimento específico.
     */
    public function show(string $uuid)
    {
        $establishment = AgendaAiEstablishment::findOrFail($uuid);
        $this->checkAccess($establishment);
        return Inertia::render('Establishments/Edit', [
            'establishment' => $establishment->only([
                'uuid', 'name', 'link', 'manual_chat_link', 'descrition', 'image'
            ]),
            'mode' => 'show'
        ]);
    }

    /**
     * Formulário de edição.
     */
    public function edit(string $uuid)
    {
        $establishment = AgendaAiEstablishment::findOrFail($uuid);
        $this->checkAccess($establishment);
        return Inertia::render('Establishments/Edit', [
            'establishment' => $establishment->only([
                'uuid', 'name', 'link', 'manual_chat_link', 'descrition', 'image'
            ]),
            'mode' => 'edit'
        ]);
    }

    /**
     * Atualiza um estabelecimento.
     */
    public function update(Request $request, string $uuid): RedirectResponse
    {
        $establishment = AgendaAiEstablishment::findOrFail($uuid);
        $this->checkAccess($establishment);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url|max:255',
            'manual_chat_link' => 'nullable|string|max:255|unique:agendaai_establishments,manual_chat_link,' . $establishment->uuid . ',uuid',
            'descrition' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $establishment->update($data);

        return redirect()->route('establishments.index')
                         ->with('success', 'Estabelecimento atualizado com sucesso.');
    }

    /**
     * Remove o estabelecimento.
     */
    public function destroy(string $uuid): RedirectResponse
    {
        $establishment = AgendaAiEstablishment::findOrFail($uuid);
        $this->checkAccess($establishment);
        $establishment->delete();

        return redirect()->route('establishments.index')
                         ->with('success', 'Estabelecimento excluído com sucesso.');
    }

    /**
     * Show edit form for the authenticated user's establishment.
     */
    public function editCurrent()
    {
        $establishment = Auth::user()->establishment;

        if (! $establishment) {
            return redirect()->route('establishments.create');
        }

        return Inertia::render('Establishments/Edit', [
            'establishment' => $establishment->only([
                'uuid', 'name', 'link', 'manual_chat_link', 'descrition', 'image'
            ]),
            'mode' => 'edit'
        ]);
    }

    private function checkAccess(AgendaAiEstablishment $establishment): void
    {
        $user = Auth::user();

        if ($user->hasRole('super-master')) {
            return;
        }

        if ($user->hasRole('master') && $establishment->user_id === $user->id) {
            return;
        }

        if ($user->hasAnyRole(['admin', 'professional']) && $user->establishment_id === $establishment->id) {
            return;
        }

        abort(403);
    }
}
