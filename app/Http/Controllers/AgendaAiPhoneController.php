<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\AgendaAiPhone;
use App\Models\AgendaAiProfessional;
use App\Models\AgendaAiEstablishment;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AgendaAiPhoneController extends Controller
{
    public function index()
    {
        $phones = AgendaAiPhone::with('professional.user', 'establishment')
                                ->latest()
                                ->paginate(15);
        return Inertia::render('Phones/Index', [
            'phones' => $phones,
        ]);
    }

    public function create()
    {
        $professionals  = AgendaAiProfessional::with('user')->get();
        $establishments = AgendaAiEstablishment::all();

        return Inertia::render('Phones/Create', [
            'professionals' => $professionals,
            'establishments' => $establishments,
        ]);
    }

    public function edit($id)
    {
        $professionals  = AgendaAiProfessional::with('user')->get();
        $establishments = AgendaAiEstablishment::all();

        $phone = AgendaAiPhone::findOrFail($id);

        return Inertia::render('Phones/Edit', [
            'phone' => $phone,
            'professionals' => $professionals,
            'establishments' => $establishments,
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ddi' => 'nullable|string|max:5',
            'ddd' => 'nullable|string|max:5',
            'phone' => 'required|string|max:20',
            'professional_id'  => 'nullable|exists:agendaai_professionals,id',
            'establishment_id' => 'nullable|exists:agendaai_establishments,id',
        ]);

        AgendaAiPhone::create([
            'ddi'  => $validated['ddi'] ?? null,
            'ddd'  => $validated['ddd'] ?? null,
            'phone' => $validated['phone'],
            'professional_id'  => $validated['professional_id'] ?? null,
            'establishment_id' => $validated['establishment_id'] ?? null,
        ]);

        return redirect()
            ->route('phones.index')
            ->with('success', 'Telefone cadastrado com sucesso.');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'ddi' => 'nullable|string|max:5',
            'ddd' => 'nullable|string|max:5',
            'phone' => 'required|string|max:20',
            'professional_id'  => 'nullable|exists:agendaai_professionals,id',
            'establishment_id' => 'nullable|exists:agendaai_establishments,id',
        ]);

        $phoneModel = AgendaAiPhone::findOrFail($id);

        $phoneModel->update([
            'ddi' => $validated['ddi'] ?? null,
            'ddd'  => $validated['ddd'] ?? null,
            'phone' => $validated['phone'],
            'professional_id'  => $validated['professional_id'] ?? null,
            'establishment_id' => $validated['establishment_id'] ?? null,
        ]);

        return redirect()
            ->route('phones.index')
            ->with('success', 'Telefone atualizado com sucesso.');
    }


    public function destroy($id): RedirectResponse
    {
        AgendaAiPhone::findOrFail($id)->delete();
        return redirect()
            ->route('phones.index')
            ->with('success', 'Telefone removido com sucesso.');
    }
}
