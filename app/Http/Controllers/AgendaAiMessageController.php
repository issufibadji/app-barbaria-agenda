<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\AgendaAiMessage;
use App\Models\AgendaAiEstablishment;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AgendaAiMessageController extends Controller
{
    public function index()
    {
        if(!Auth::user()->can('agendaai::listar-messages')){
            Session::flash('error', 'Permissão Negada!');
            return redirect->back();
        }
        $messages = AgendaAiMessage::with('establishment')
                      ->orderBy('created_at','desc')
                      ->get();

        return Inertia::render('Agenda/Messages/Index', [
            'messages' => $messages,
        ]);
    }

    public function create()
    {
        $establishments = AgendaAiEstablishment::pluck('name','id');
        $message = new AgendaAiMessage();
        return Inertia::render('Agenda/Messages/Create', [
            'establishments' => $establishments,
            'message' => $message,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type'             => 'required|string|max:100',
            'message'          => 'required|string',
            'establishment_id' => 'required|exists:agendaai_establishments,id',
        ]);

        AgendaAiMessage::create($validated);

        return redirect()
            ->route('agendaai.messages.index')
            ->with('success','Mensagem criada com sucesso.');
    }

    public function edit(int $id)
    {
        $message = AgendaAiMessage::findOrFail($id);
        $establishments = AgendaAiEstablishment::pluck('name','id');
        return Inertia::render('Agenda/Messages/Edit', [
            'message' => $message,
            'establishments' => $establishments,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $message = AgendaAiMessage::findOrFail($id);

        $validated = $request->validate([
            'type'             => 'required|string|max:100',
            'message'          => 'required|string',
            'establishment_id' => 'required|exists:agendaai_establishments,id',
        ]);

        $message->update($validated);

        return redirect()
            ->route('agendaai.messages.index')
            ->with('success','Mensagem atualizada com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        AgendaAiMessage::findOrFail($id)->delete();

        return redirect()
            ->route('agendaai.messages.index')
            ->with('success','Mensagem excluída com sucesso.');
    }
}
