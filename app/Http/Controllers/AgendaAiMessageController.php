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
        $messages = AgendaAiMessage::with('establishment')
                      ->orderBy('created_at','desc')
                      ->get();

        return Inertia::render('Messages/Index', [
            'messages' => $messages,
        ]);
    }

    public function create()
    {
        $establishments = AgendaAiEstablishment::pluck('name','id');
        $message = new AgendaAiMessage();
        return Inertia::render('Messages/Create', [
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
            ->route('messages.index')
            ->with('success','Mensagem criada com sucesso.');
    }

    public function edit(int $id)
    {
        $message = AgendaAiMessage::findOrFail($id);
        $establishments = AgendaAiEstablishment::pluck('name','id');
        return Inertia::render('Messages/Edit', [
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
            ->route('messages.index')
            ->with('success','Mensagem atualizada com sucesso.');
    }


    public function bulkUpdate(Request $request)
     {
    foreach ($request->messages as $id => $content) {
        AgendaAiMessage::where('id', $id)->update(['message' => $content]);
    }

    return redirect()->back()->with('success', 'Mensagens atualizadas com sucesso.');
  }

    public function destroy(int $id): RedirectResponse
    {
        AgendaAiMessage::findOrFail($id)->delete();

        return redirect()
            ->route('messages.index')
            ->with('success','Mensagem excluída com sucesso.');
    }
}
