<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\AgendaAiSchedule;
use App\Models\AgendaAiProfessional;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AgendaAiScheduleController extends Controller
{
    public function index()
    {
        $schedules = AgendaAiSchedule::with('professional.user')
                        ->latest()
                        ->paginate(15);

        return Inertia::render('Schedules/Index', [
            'schedules' => $schedules,
        ]);
    }

    public function create()
    {
        $professionals = AgendaAiProfessional::with('user')
                    ->get()
                    ->pluck('user.name', 'id');

        return Inertia::render('Schedules/Create', [
            'professionals' => $professionals,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'schedule'        => 'required|string|max:255',
            'professional_id' => 'required|exists:agendaai_professionals,id',
        ]);

        AgendaAiSchedule::create($data);

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Agenda criada com sucesso.');
    }

    public function edit(int $id)
    {
        $schedule = AgendaAiSchedule::findOrFail($id);

        $professionals = AgendaAiProfessional::with('user')
                            ->get()
                            ->pluck('user.name', 'id');
        return Inertia::render('Schedules/Edit', [
            'schedule' => $schedule,
            'professionals' => $professionals,
        ]);
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
            ->route('schedules.index')
            ->with('success', 'Agenda atualizada com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        AgendaAiSchedule::findOrFail($id)->delete();

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Agenda removida com sucesso.');
    }
}
