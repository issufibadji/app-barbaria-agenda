<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\AgendaAiClient;
use Inertia\Inertia;
class AgendaAiClientController extends Controller
{
    /**
     * Exibe a listagem de clientes.
     */
    public function index()
    {
        // verifica permissão antes de buscar os registros
        if (! Auth::user()->can('agendaai::listar-clients')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }

        $clients = AgendaAiClient::with('user')
                    ->latest()
                    ->paginate(15);

        return Inertia::render('Agenda/Clients/Index', [
            'clients' => $clients,
        ]);
    }


    /**
     * Mostra o formulário de criação de cliente.
     */
    public function create()
    {
        // lista de usuários para o select [id => name]
        $users = User::orderBy('name')->pluck('name','id');

        return Inertia::render('Agenda/Clients/Create', [
            'users' => $users,
        ]);
    }

    /**
     * Persiste um novo cliente no banco.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'gender'  => 'nullable|string|max:20',
        ]);

        AgendaAiClient::create($data);

        return redirect()
            ->route('agendaai.clients.index')
            ->with('success', 'Cliente criado com sucesso.');
    }

    /**
     * Mostra o formulário de edição de um cliente.
     */
    public function edit(int $id)
    {
        $client = AgendaAiClient::findOrFail($id);

        // lista de usuários para o select
        $users = User::orderBy('name')->pluck('name','id');

        return Inertia::render('Agenda/Clients/Edit', [
            'client' => $client,
            'users' => $users,
        ]);
    }

    /**
     * Atualiza os dados de um cliente existente.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $client = AgendaAiClient::findOrFail($id);

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'gender'  => 'nullable|string|max:20',
        ]);

        $client->update($data);

        return redirect()
            ->route('agendaai.clients.index')
            ->with('success', 'Cliente atualizado com sucesso.');
    }

    /**
     * Remove um cliente (soft ou hard delete).
     */
    public function destroy(int $id): RedirectResponse
    {
        $client = AgendaAiClient::findOrFail($id);
        $client->delete();

        return redirect()
            ->route('agendaai.clients.index')
            ->with('success', 'Cliente removido com sucesso.');
    }
}
