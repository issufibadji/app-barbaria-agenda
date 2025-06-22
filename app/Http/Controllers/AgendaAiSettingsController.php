<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;

class AgendaAiSettingsController extends Controller
{

public function index()
{
    $user = Auth::user();
    $establishment = $user->establishment;

    return Inertia::render('Settings/ConfigEstablishment', [
        'establishment' => $establishment,
        'services' => $establishment?->services()->get() ?? [],
        'professionals' => $establishment?->professionals()->get() ?? [],
    ]);
}



}
