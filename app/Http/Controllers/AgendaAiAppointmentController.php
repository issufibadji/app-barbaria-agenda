<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\AgendaAiAppointment;
use App\Models\AgendaAiService;
use App\Models\AgendaAiClient;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AgendaAiAppointmentController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('agendaai::listar-appointments')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $appointments = AgendaAiAppointment::with(['service','client.user'])
            ->latest()
            ->paginate(15);

        return Inertia::render('Agenda/Appointments/Index', [
            'appointments' => $appointments,
        ]);
    }

    public function create()
    {
        // agora em inglês: 'service' e 'client'
        $services = AgendaAiService::pluck('name', 'id');
        $clients  = AgendaAiClient::with('user')
                     ->get()
                     ->pluck('user.name', 'id');

        return Inertia::render('Agenda/Appointments/Create', [
            'services' => $services,
            'clients' => $clients,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'service_id'   => 'required|exists:agendaai_services,id',
            'client_id'    => 'required|exists:agendaai_clients,id',
            'scheduled_at' => 'required|date',
            'status'       => 'required|in:pendente,confirmado,cancelado',
        ]);

        AgendaAiAppointment::create($data);

        return redirect()
            ->route('agendaai.appointments.index')
            ->with('success', 'Agendamento criado com sucesso.');
    }

    public function edit(int $id)
    {
        $appointment = AgendaAiAppointment::findOrFail($id);

        $services = AgendaAiService::pluck('name', 'id');
        $clients  = AgendaAiClient::with('user')
                     ->get()
                     ->pluck('user.name', 'id');

        return Inertia::render('Agenda/Appointments/Edit', [
            'appointment' => $appointment,
            'services' => $services,
            'clients' => $clients,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $appointment = AgendaAiAppointment::findOrFail($id);

        $data = $request->validate([
            'service_id'   => 'required|exists:agendaai_services,id',
            'client_id'    => 'required|exists:agendaai_clients,id',
            'scheduled_at' => 'required|date',
            'status'       => 'required|in:pendente,confirmado,cancelado',
        ]);

        $appointment->update($data);

        return redirect()
            ->route('agendaai.appointments.index')
            ->with('success', 'Agendamento atualizado com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        AgendaAiAppointment::findOrFail($id)->delete();

        return redirect()
            ->route('agendaai.appointments.index')
            ->with('success', 'Agendamento excluído com sucesso.');
    }
}
