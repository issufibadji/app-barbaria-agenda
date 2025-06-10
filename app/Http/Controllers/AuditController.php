<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Log;
use App\Models\User;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
   public function index()
    {
        $audits = Audit::with('user')->latest()->paginate(10);
        return Inertia::render('Audits/Index', [
            'audits' => $audits,
        ]);
    }

    public function index(Request $request)
    {
        if (!Auth::user()->can('audit-all')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        // Inicializar a consulta
        $query = Audit::query();

        // Aplicar filtro de evento, se presente
        if ($request->filled('event')) {
            $query->where('event', $request->input('event'));
        }

        // Aplicar filtro de user_id, se presente
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        // Buscar os registros de auditoria com os filtros aplicados
        $audits = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('audit.index', compact('audits'));
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
