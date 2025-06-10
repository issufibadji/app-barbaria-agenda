<?php

namespace Modules\AgendaAi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Modules\AgendaAi\Entities\AgendaAiPlan;
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
        return view('agendaai::agendaai_plans.index', compact('plans'));
    }

    public function indexCustomer()
    {
        if (!Auth::user()->can('agendaai::listar-plans-customer')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $plans = AgendaAiPlan::orderBy('created_at','desc')->where('active','=', true)->get();
        return view('agendaai::agendaai_plans.index-customer', compact('plans'));
    }

    

    public function create()
    {
        if (!Auth::user()->can('agendaai::listar-plans')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        return view('agendaai::agendaai_plans.create');
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
        return view('agendaai::agendaai_plans.edit', compact('plan'));
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
