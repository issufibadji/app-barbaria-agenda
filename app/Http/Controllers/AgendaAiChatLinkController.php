<?php

namespace App\Http\Controllers;

use App\Models\AgendaAiEstablishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
        $establishment = Auth::user()->establishment;

        $request->validate([
            'manual_chat_link' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9\-]+$/i',
                'unique:agendaai_establishments,manual_chat_link,' . $user->establishment->id,
            ],
        ]);

        $establishment->manual_chat_link = $request->manual_chat_link;
        $establishment->save();

        return redirect()->route('settings.chat-link.edit')->with('success', 'Link atualizado com sucesso!');
    }
}
