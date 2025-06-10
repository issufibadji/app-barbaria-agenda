<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\AgendaAiPlan;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AgendaAiPlanController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('agendaai::listar-plans')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $plans = AgendaAiPlan::orderBy('created_at',direction: 'desc')->get();
        return Inertia::render('Agenda/Plans/Index', [
            'plans' => $plans,
        ]);
    }

    public function indexCustomer()
    {
        if (!Auth::user()->can('agendaai::listar-plans-customer')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $plans = AgendaAiPlan::orderBy('created_at','desc')->where('active','=', true)->get();
        return Inertia::render('Agenda/Plans/IndexCustomer', [
            'plans' => $plans,
        ]);
    }

    

    public function create()
    {
        if (!Auth::user()->can('agendaai::listar-plans')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        return Inertia::render('Agenda/Plans/Create');
    }

    public function store(Request $request): RedirectResponse
    {

        if (!Auth::user()->can('agendaai::listar-plans')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'days'       => 'required|integer|min:0',
            'price'      => 'required|numeric|min:0',
            'descrition' => 'nullable|string',
        ]);

        // if checkbox absent, force false
        $validated['active'] = $request->has('active');

        AgendaAiPlan::create($validated);

        return redirect()
            ->route('agendaai.plans.index')
            ->with('success','Plano criado com sucesso.');
    }

    public function edit(int $id)
    {
        if (!Auth::user()->can('agendaai::listar-plans')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }

        $plan = AgendaAiPlan::findOrFail($id);
        return Inertia::render('Agenda/Plans/Edit', [
            'plan' => $plan,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {

        if (!Auth::user()->can('agendaai::listar-plans')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }

        $plan = AgendaAiPlan::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'days'       => 'required|integer|min:0',
            'price'      => 'required|numeric|min:0',
            'descrition' => 'nullable|string',
        ]);
        $validated['active'] = $request->has('active');

        $plan->update($validated);

        return redirect()
            ->route('agendaai.plans.index')
            ->with('success','Plano atualizado com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {

        if (!Auth::user()->can('agendaai::listar-plans')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        
        AgendaAiPlan::findOrFail($id)->delete();

        return redirect()
            ->route('agendaai.plans.index')
            ->with('success','Plano excluído com sucesso.');
    }
}
