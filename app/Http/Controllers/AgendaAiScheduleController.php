<?php

namespace Modules\AgendaAi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Modules\AgendaAi\Entities\AgendaAiSchedule;
use Modules\AgendaAi\Entities\AgendaAiProfessional;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AgendaAiScheduleController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('agendaai::listar-schedules')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $schedules = AgendaAiSchedule::with('professional.user')
                        ->latest()
                        ->paginate(15);

        return view('agendaai::agendaai_schedules.index', compact('schedules'));
    }

    public function create()
    {
        $professionals = AgendaAiProfessional::with('user')
                    ->get()
                    ->pluck('user.name', 'id');

        return view('agendaai::agendaai_schedules.create', compact('professionals'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'schedule'        => 'required|string|max:255',
            'professional_id' => 'required|exists:agendaai_professionals,id',
        ]);

        AgendaAiSchedule::create($data);

        return redirect()
            ->route('agendaai.schedules.index')
            ->with('success', 'Agenda criada com sucesso.');
    }

    public function edit(int $id)
    {
        $schedule = AgendaAiSchedule::findOrFail($id);

        $professionals = AgendaAiProfessional::with('user')
                            ->get()
                            ->pluck('user.name', 'id');
        return view('agendaai::agendaai_schedules.edit', compact('schedule','professionals'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $schedule = AgendaAiSchedule::findOrFail($id);

        $data = $request->validate([
            'schedule' => 'required|string|max:255',
            'professional_id' => 'required|exists:agendaai_professionals,id',
        ]);

        $schedule->update($data);

        return redirect()
            ->route('agendaai.schedules.index')
            ->with('success', 'Agenda atualizada com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        AgendaAiSchedule::findOrFail($id)->delete();

        return redirect()
            ->route('agendaai.schedules.index')
            ->with('success', 'Agenda removida com sucesso.');
    }
}
