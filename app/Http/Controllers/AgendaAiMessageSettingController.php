<?php
namespace App\Http\Controllers;

use App\Models\AgendaAiMessageSetting;
use App\Models\AgendaAiEstablishment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AgendaAiMessageSettingController extends Controller
{
    public function index()
    {
        $establishmentId = auth()->user()->establishment_id;

        $messages = AgendaAiMessageSetting::where('establishment_id', $establishmentId)
            ->get()
            ->groupBy('type');

        return Inertia::render('Messages/Settings', [
            'messages' => $messages,
        ]);
    }

    public function update(Request $request)
    {
        $establishmentId = auth()->user()->establishment_id;

        foreach ($request->input('messages') as $type => $message) {
            AgendaAiMessageSetting::updateOrCreate(
                ['establishment_id' => $establishmentId, 'type' => $type],
                ['message' => $message]
            );
        }

        return redirect()->back()->with('success', 'Mensagens atualizadas com sucesso!');
    }
}
