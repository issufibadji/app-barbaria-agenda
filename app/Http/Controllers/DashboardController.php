<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $showEstablishmentPanel = $user->hasRole('admin') || $user->hasRole('professional');
        $establishment = $user->establishment;

        $establishmentData = $establishment ? [
            'name' => $establishment->name ?? '---',
            'cnpj' => $establishment->cnpj ?? '---',
            'address' => optional($establishment->address)->full_address ?? '---',
            'phone' => optional($establishment->phone)->number ?? '---',
            'appointments_count' => $establishment->appointments()->count(),
            'professionals_count' => $establishment->professionals()->count(),
            'clients_count' => $establishment->clients()->count(),
            'revenue' => $establishment->payments()->sum('amount'),
        ] : [
            'name' => '---',
            'cnpj' => '---',
            'address' => '---',
            'phone' => '---',
            'appointments_count' => 0,
            'professionals_count' => 0,
            'clients_count' => 0,
            'revenue' => 0,
        ];

        // Gráfico: agendamentos por dia da semana
        $weeklyAppointments = [];
        if ($establishment) {
            $appointments = DB::table('agendaai_appointments')
                ->select(DB::raw('DAYOFWEEK(date) as weekday'), DB::raw('COUNT(*) as count'))
                ->where('establishment_id', $establishment->uuid)
                ->groupBy('weekday')
                ->orderBy('weekday')
                ->get();

            $diasSemana = [
                1 => 'Domingo',
                2 => 'Segunda',
                3 => 'Terça',
                4 => 'Quarta',
                5 => 'Quinta',
                6 => 'Sexta',
                7 => 'Sábado',
            ];

            foreach ($diasSemana as $index => $label) {
                $match = $appointments->firstWhere('weekday', $index);
                $weeklyAppointments[] = [
                    'day' => $label,
                    'count' => $match ? $match->count : 0,
                ];
            }
        }

        // Detalhamento: agendamentos da semana atual por data (formato Y-m-d)
        $appointmentsWeek = [];

        if ($establishment) {
            $start = Carbon::now()->startOfWeek(); // segunda
            $end = Carbon::now()->endOfWeek();     // domingo

            $rows = \App\Models\AgendaAiAppointment::with(['client', 'service'])
                ->where('establishment_id', $establishment->uuid)
                ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
                ->orderBy('date')
                ->orderBy('time')
                ->get();

            foreach ($rows as $row) {
                $key = Carbon::parse($row->date)->format('Y-m-d');
                $appointmentsWeek[$key][] = [
                    'time' => $row->time,
                    'price' => $row->price,
                    'client' => ['name' => $row->client->name ?? ''],
                    'service' => ['name' => $row->service->name ?? ''],
                ];
            }

        }

        return Inertia::render('Dashboard', [
            'showEstablishmentPanel' => $showEstablishmentPanel,
            'establishment' => $establishmentData,
            'weeklyAppointments' => $weeklyAppointments,
            'appointmentsWeek' => $appointmentsWeek,
        ]);
    }
}
