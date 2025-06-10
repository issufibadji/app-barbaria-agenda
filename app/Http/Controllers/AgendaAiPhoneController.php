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
        if (!Auth::user()->can('agendaai::listar-phones')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $phones = AgendaAiPhone::with('professional.user', 'establishment')->latest()->get();
        return Inertia::render('Agenda/Phones/Index', [
            'phones' => $phones,
        ]);
    }

    public function create()
    {
        $professionals  = AgendaAiProfessional::with('user')->get();
        $establishments = AgendaAiEstablishment::all();

        // 1. tenta recuperar old() se veio de validação
        $phonesOld = old('phones', null);

        // 2. se não veio old, cria um array com um telefone vazio
        $phones = $phonesOld ?: [[
            'ddi' => '',
            'ddd' => '',
            'phone' => '',
            'professional_id'  => null,
            'establishment_id' => null,
        ]];

        return Inertia::render('Agenda/Phones/Create', [
            'professionals' => $professionals,
            'establishments' => $establishments,
            'phones' => $phones,
        ]);
    }

    public function edit($id)
    {
        $professionals  = AgendaAiProfessional::with('user')->get();
        $establishments = AgendaAiEstablishment::all();

        $phone = AgendaAiPhone::findOrFail($id);

        $phonesOld = old('phones', null);
        $phones = $phonesOld ?: [[
            'ddi' => $phone->ddi,
            'ddd'  => $phone->ddd,
            'phone' => $phone->phone,
            'professional_id'  => $phone->professional_id,
            'establishment_id' => $phone->establishment_id,
        ]];

        return Inertia::render('Agenda/Phones/Edit', [
            'phone' => $phone,
            'professionals' => $professionals,
            'establishments' => $establishments,
            'phones' => $phones,
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'phones.*.ddi' => 'nullable|string|max:5',
            'phones.*.ddd' => 'nullable|string|max:5',
            'phones.*.phone' => 'required|string|max:20',
            'phones.*.professional_id'  => 'nullable|exists:agendaai_professionals,id',
            'phones.*.establishment_id' => 'nullable|exists:agendaai_establishments,id',
        ]);

        foreach ($validated['phones'] as $phone) {
            if (empty($phone['phone'])) continue;

            AgendaAiPhone::create([
                'ddi'  => $phone['ddi']              ?? null,
                'ddd'  => $phone['ddd']              ?? null,
                'phone' => $phone['phone'],
                'professional_id'  => $phone['professional_id']  ?? null,
                'establishment_id' => $phone['establishment_id'] ?? null,
            ]);
        }

        return redirect()
            ->route('agendaai.phones.index')
            ->with('success', 'Telefone cadastrado com sucesso.');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'phones.*.ddi' => 'nullable|string|max:5',
            'phones.*.ddd' => 'nullable|string|max:5',
            'phones.*.phone' => 'required|string|max:20',
            'phones.*.professional_id'  => 'nullable|exists:agendaai_professionals,id',
            'phones.*.establishment_id' => 'nullable|exists:agendaai_establishments,id',
        ]);

        $phoneModel = AgendaAiPhone::findOrFail($id);

        // usa apenas o primeiro telefone do array
        $item = $validated['phones'][0];

        $phoneModel->update([
            'ddi' => $item['ddi'] ?? null,
            'ddd'  => $item['ddd'] ?? null,
            'phone' => $item['phone'],
            'professional_id'  => $item['professional_id']  ?? null,
            'establishment_id' => $item['establishment_id'] ?? null,
        ]);

        return redirect()
            ->route('agendaai.phones.index')
            ->with('success', 'Telefone atualizado com sucesso.');
    }


    public function destroy($id): RedirectResponse
    {
        AgendaAiPhone::findOrFail($id)->delete();
        return redirect()
            ->route('agendaai.phones.index')
            ->with('success', 'Telefone removido com sucesso.');
    }
}
