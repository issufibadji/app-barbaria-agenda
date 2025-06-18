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
        $plans = AgendaAiPlan::orderBy('created_at',direction: 'desc')->get();
        return Inertia::render('Plans/Index', [
            'plans' => $plans,
        ]);
    }

    public function indexCustomer()
    {
        $plans = AgendaAiPlan::orderBy('created_at','desc')->where('active','=', true)->get();
        return Inertia::render('Plans/IndexCustomer', [
            'plans' => $plans,
        ]);
    }



    public function create()
    {
        return Inertia::render('Plans/Create');
    }

   public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'days'       => 'required|integer|min:0',
            'price'      => 'required|numeric|min:0',
            'descrition' => 'nullable|string',
            'features'   => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
        ]);

        $validated['active'] = $request->has('active');
        $validated['features'] = array_filter($request->input('features', []));

        AgendaAiPlan::create($validated);

        return redirect()->route('plans.index')->with('success', 'Plano criado com sucesso.');
    }

    public function edit(int $id)
    {
        $plan = AgendaAiPlan::findOrFail($id);
        return Inertia::render('Plans/Edit', [
            'plan' => $plan,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $plan = AgendaAiPlan::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'days'       => 'required|integer|min:0',
            'price'      => 'required|numeric|min:0',
            'descrition' => 'nullable|string',
            'features'   => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
        ]);

        $validated['active'] = $request->has('active');
        $validated['features'] = array_filter($request->input('features', []));

        $plan->update($validated);

        return redirect()->route('plans.index')->with('success', 'Plano atualizado com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        AgendaAiPlan::findOrFail($id)->delete();

        return redirect()
            ->route('plans.index')
            ->with('success','Plano excluído com sucesso.');
    }
}
