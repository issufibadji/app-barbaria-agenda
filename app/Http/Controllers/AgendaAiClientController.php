<?php

namespace App\Http\Controllers;

use App\Models\AgendaAiClient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class AgendaAiClientController extends Controller
{
    // você já está protegido pelo auth+role:admin nas rotas

    public function index()
    {
        $clients = AgendaAiClient::with('user')
                        ->latest()
                        ->paginate(15);

        return Inertia::render('Clients/Index', [
            'clients' => $clients,
        ]);
    }

    public function create()
    {
        $users = User::orderBy('name')->pluck('name','id');
        return Inertia::render('Clients/Create', [
            'users' => $users,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'gender'  => 'nullable|string|max:20',
        ]);

        AgendaAiClient::create($data);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente criado com sucesso.');
    }

    public function edit(AgendaAiClient $client)
    {
        $users = User::orderBy('name')->pluck('name','id');
        return Inertia::render('Clients/Edit', [
            'client' => $client,
            'users'  => $users,
        ]);
    }

    public function update(Request $request, AgendaAiClient $client): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'gender'  => 'nullable|string|max:20',
        ]);

        $client->update($data);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy(AgendaAiClient $client): RedirectResponse
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente removido com sucesso.');
    }
}
