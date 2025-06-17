<?php

namespace App\Http\Controllers;

use App\Models\AgendaAiEstablishment;
use Inertia\Inertia;

class PublicChatController extends Controller
{
    public function show($slug)
    {
        $establishment = AgendaAiEstablishment::where('manual_chat_link', $slug)->firstOrFail();

        return Inertia::render('Public/Chat', [
            'establishment' => $establishment,
            // você pode passar serviços, horários disponíveis, etc.
        ]);
    }
}
