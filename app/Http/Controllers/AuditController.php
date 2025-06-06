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
