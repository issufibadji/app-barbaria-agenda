<?php
namespace Modules\AgendaAi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Modules\AgendaAi\Entities\AgendaAiAddressEstablishment;
use Modules\AgendaAi\Entities\AgendaAiEstablishment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AgendaAiAddressEstablishmentController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('agendaai::listar-addresses')) {
            Session::flash('error', 'Permissão Negada!');
            return redirect()->back();
        }

        $addresses = AgendaAiAddressEstablishment::with('establishment')
                        ->latest()
                        ->paginate(15);
        return view('agendaai::agendaai_address_establishments.index', compact('addresses'));
    }

    public function create()
    {
        $establishments = AgendaAiEstablishment::pluck('name','id');
        return view('agendaai::agendaai_address_establishments.create', compact('establishments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'cep'               => 'nullable|string|max:20',
            'uf'                => 'nullable|string|max:2',
            'city'              => 'nullable|string|max:100',
            'street'            => 'nullable|string|max:255',
            'complement'        => 'nullable|string|max:255',
            'establishment_id'  => 'required|exists:agendaai_establishments,id',
        ]);

        AgendaAiAddressEstablishment::create($data);

        return redirect()->route('agendaai.addresses.index')
                         ->with('success','Address created.');
    }

    public function edit(int $id)
    {
        $address = AgendaAiAddressEstablishment::findOrFail($id);
        $establishments = AgendaAiEstablishment::pluck('name','id');
        return view('agendaai::agendaai_address_establishments.edit', compact('address','establishments'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $address = AgendaAiAddressEstablishment::findOrFail($id);
        $data = $request->validate([
            'cep'               => 'nullable|string|max:20',
            'uf'                => 'nullable|string|max:2',
            'city'              => 'nullable|string|max:100',
            'street'            => 'nullable|string|max:255',
            'complement'        => 'nullable|string|max:255',
            'establishment_id'  => 'required|exists:agendaai_establishments,id',
        ]);

        $address->update($data);

        return redirect()->route('agendaai.addresses.index')
                         ->with('success','Address updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        AgendaAiAddressEstablishment::findOrFail($id)->delete();
        return redirect()->route('agendaai.addresses.index')
                         ->with('success','Address deleted.');
    }
}
