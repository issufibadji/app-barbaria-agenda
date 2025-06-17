<?php

namespace App\Http\Controllers;

use App\Models\AgendaAiEstablishment;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function show(AgendaAiEstablishment $establishment)
    {
        return Inertia::render('Chat/Show', [
            'establishment' => $establishment,
        ]);
    }
}
