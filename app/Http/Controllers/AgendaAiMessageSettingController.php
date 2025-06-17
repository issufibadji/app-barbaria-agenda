<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\AgendaAiMessageSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AgendaAiMessageSettingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $establishmentId = $user->establishment_id ?? null;

        $messages = AgendaAiMessageSetting::where('establishment_id', $establishmentId)->get();

        return Inertia::render('Messages/Settings', [
            'messages' => $messages,
        ]);
    }

public function update(Request $request)
{
    $user = Auth::user();
    $establishmentId = $user->establishment->id ?? null;

    if (!$establishmentId) {
        return back()->withErrors(['msg' => 'Estabelecimento não encontrado.']);
    }

    foreach ($request->messages as $type => $message) {
        AgendaAiMessageSetting::updateOrCreate(
            ['type' => $type, 'establishment_id' => $establishmentId],
            ['message' => $message]
        );
    }

    return redirect()->back()->with('success', 'Mensagens salvas com sucesso!');
}

}
