<?php

namespace App\Http\Controllers;

use App\Models\AgendaAiEstablishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AgendaAiChatLinkController extends Controller
{
    public function edit()
    {
        $establishment = Auth::user()->establishment;

        return Inertia::render('Settings/ChatLink', [
            'chat_link' => $establishment->manual_chat_link ?? '',
        ]);
    }

    public function update(Request $request)
    {
       $request->validate([
            'link' => ['required', 'string', 'max:255', Rule::unique('agendaai_establishments', 'manual_chat_link')->ignore($establishment->id)],
        ]);


        $establishment = Auth::user()->establishment;
        $establishment->manual_chat_link = $request->manual_chat_link;
        $establishment->save();

        return redirect()->route('settings.chat-link.edit')->with('success', 'Link atualizado com sucesso!');
    }
}
