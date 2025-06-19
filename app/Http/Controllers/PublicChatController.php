<?php

namespace App\Http\Controllers;

use App\Models\AgendaAiEstablishment;
use App\Models\AgendaAiMessageSetting;
use Inertia\Inertia;

class PublicChatController extends Controller
{
    public function show($slug)
{
    $establishment = AgendaAiEstablishment::where('manual_chat_link', $slug)->firstOrFail();

    // Buscar mensagens do próprio estabelecimento OU as padrões (establishment_id null)
    $messagesRaw = AgendaAiMessageSetting::where(function ($q) use ($establishment) {
        $q->whereNull('establishment_id')
          ->orWhere('establishment_id', $establishment->id);
    })->get();

    $messages = $messagesRaw->pluck('message', 'type');

    return Inertia::render('Public/Chat', [
        'establishment' => $establishment,
        'messages' => $messages,
    ]);
}


    public function services(AgendaAiEstablishment $establishment)
    {
        return response()->json($establishment->services()->select('id', 'name', 'price')->get());
    }

    public function messages(AgendaAiEstablishment $establishment)
    {
        return response()->json($establishment->messageSettings()->select('type', 'message')->get());
    }
}
