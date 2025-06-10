<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->can('audit-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }

        $query = Audit::with('user');

        if ($request->filled('event')) {
            $query->where('event', $request->input('event'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        $audits = $query->orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Audits/Index', [
            'audits' => $audits,
            'filters' => $request->only(['event', 'user_id', 'start_date', 'end_date']),
        ]);
    }

    public function show(Audit $audit)
    {
        $audit->load('user');
        return Inertia::render('Audits/Show', [
            'audit' => $audit,
        ]);
    }

    public function destroy(Audit $audit)
    {
        $audit->delete();
        return redirect()->route('audits.index')->with('success', 'Auditoria removida com sucesso.');
    }
}
