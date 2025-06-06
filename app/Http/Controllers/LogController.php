<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Log;
use App\Models\User;

class LogController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Logs/Index', [
            'logs' => Log::with('user')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Logs/Create', [
            'users' => User::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'action' => 'required|string',
            'details' => 'nullable|string',
        ]);

        Log::create([
            'user_id' => $data['user_id'],
            'user_type' => $data['user_id'] ? User::class : null,
            'event' => $data['action'],
            'tags' => $data['details'] ?? null,
        ]);

        return redirect()->route('logs.index')->with('success', 'Log criado com sucesso.');
    }

    public function edit(Log $log)
    {
        return Inertia::render('Admin/Logs/Edit', [
            'log' => $log->load('user'),
            'users' => User::all(),
        ]);
    }

    public function update(Request $request, Log $log)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'action' => 'required|string',
            'details' => 'nullable|string',
        ]);

        $log->update([
            'user_id' => $data['user_id'],
            'user_type' => $data['user_id'] ? User::class : null,
            'event' => $data['action'],
            'tags' => $data['details'] ?? null,
        ]);

        return redirect()->route('logs.index')->with('success', 'Log atualizado com sucesso.');
    }

    public function destroy(Log $log)
    {
        $log->delete();
        return redirect()->route('logs.index')->with('success', 'Log removido com sucesso.');
    }
}
