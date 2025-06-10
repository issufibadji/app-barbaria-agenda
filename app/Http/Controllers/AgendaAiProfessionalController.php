<?php

namespace Modules\AgendaAi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Modules\AgendaAi\Entities\AgendaAiProfessional;
use Modules\AgendaAi\Entities\AgendaAiEstablishment;
use Modules\AgendaAi\Entities\AgendaAiPhone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AgendaAiProfessionalController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('agendaai::listar-professionals')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }
        $professionals = AgendaAiProfessional::with('establishment', 'phones')
                            ->latest()
                            ->get();

        return view('agendaai::agendaai_professionals.index', compact('professionals'));
    }

    public function create()
    {
        $users = User::orderBy('name')->pluck('name', 'id');
        $establishments = AgendaAiEstablishment::all();

        // Placeholder para start do formulário de telefones (caso queira já exibir um)
        $phones = old('phones', [[
            'ddi' => '',
            'ddd' => '',
            'phone' => '',
            'establishment_id' => null,
        ]]);

        return view('agendaai::agendaai_professionals.create', compact(
            'users', 'establishments', 'phones'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'commission' => 'required|numeric|min:0|max:100',
            'establishment_id' => 'required|exists:agendaai_establishments,id',
            'phones.*.ddi' => 'nullable|string|max:5',
            'phones.*.ddd' => 'nullable|string|max:5',
            'phones.*.phone' => 'nullable|string|max:20',
        ]);

        $professional = AgendaAiProfessional::create($validated);

        if ($request->has('phones')) {
            foreach ($request->phones as $phone) {
                if (empty($phone['phone'])) continue;

                AgendaAiPhone::create([
                    'ddi'  => $phone['ddi'] ?? null,
                    'ddd'  => $phone['ddd'] ?? null,
                    'phone' => $phone['phone'],
                    'professional_id'  => $professional->id,              // ← adicionado
                    'establishment_id' => $professional->establishment_id,
                ]);
            }
        }

        return redirect()
            ->route('agendaai.professionals.index')
            ->with('success', 'Profissional cadastrado com sucesso.');
    }

    public function edit(string $uuid)
    {
        $professional = AgendaAiProfessional::with('phones')
                            ->where('uuid', $uuid)
                            ->firstOrFail();

        $users = User::orderBy('name')->pluck('name', 'id');
        $establishments = AgendaAiEstablishment::all();

        // Se voltou de validação com old(), usa aquilo; senão monta do Model
        $phonesOld = old('phones', null);
        $phones    = $phonesOld ?: $professional->phones->map(function($p) {
            return [
                'ddi' => $p->ddi,
                'ddd'=> $p->ddd,
                'phone' => $p->phone,
                'establishment_id' => $p->establishment_id,
            ];
        })->toArray();

        return view('agendaai::agendaai_professionals.edit', compact(
            'professional', 'users', 'establishments', 'phones'
        ));
    }

    public function update(Request $request, string $uuid): RedirectResponse
    {
        $professional = AgendaAiProfessional::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'user_id'=> 'required|exists:users,id',
            'commission'=> 'required|numeric|min:0|max:100',
            'establishment_id'=>'required|exists:agendaai_establishments,id',
            'phones.*.ddi'=>'nullable|string|max:5',
            'phones.*.ddd' =>'nullable|string|max:5',
            'phones.*.phone'=>'nullable|string|max:20',
        ]);

        $professional->update($validated);

        // Limpa os antigos e cadastra os novos, ligando ao professional_id
        AgendaAiPhone::where('professional_id', $professional->id)->delete();

        foreach ($request->phones ?? [] as $phone) {
            if (empty($phone['phone'])) continue;

            AgendaAiPhone::create([
                'ddi'=> $phone['ddi'] ?? null,
                'ddd' => $phone['ddd'] ?? null,
                'phone' => $phone['phone'],
                'professional_id' => $professional->id,
                'establishment_id' => $professional->establishment_id,
            ]);
        }

        return redirect()
            ->route('agendaai.professionals.index')
            ->with('success', 'Profissional atualizado com sucesso.');
    }

    public function destroy(string $uuid): RedirectResponse
    {
        $professional = AgendaAiProfessional::where('uuid', $uuid)->firstOrFail();

        AgendaAiPhone::where('professional_id', $professional->id)->delete();
        $professional->delete();

        return redirect()
            ->route('agendaai.professionals.index')
            ->with('success', 'Profissional removido com sucesso.');
    }
}
