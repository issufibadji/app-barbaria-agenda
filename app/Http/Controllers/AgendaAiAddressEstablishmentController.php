<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\AgendaAiAddressEstablishment;
use App\Models\AgendaAiEstablishment;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AgendaAiAddressEstablishmentController extends Controller
{
    public function index()
    {
        $addresses = AgendaAiAddressEstablishment::with('establishment')
                        ->latest()
                        ->paginate(15);
        return Inertia::render('Addresses/Index', [
            'addresses' => $addresses,
        ]);
    }

    public function create()
    {
        $establishments = AgendaAiEstablishment::pluck('name','id');
        return Inertia::render('Addresses/Create', [
            'establishments' => $establishments,
        ]);
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

        return redirect()->route('addresses.index')
                         ->with('success','Address created.');
    }

    public function edit(int $id)
    {
        $address = AgendaAiAddressEstablishment::findOrFail($id);
        $establishments = AgendaAiEstablishment::pluck('name','id');
        return Inertia::render('Addresses/Edit', [
            'address' => $address,
            'establishments' => $establishments,
        ]);
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

        return redirect()->route('addresses.index')
                         ->with('success','Address updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        AgendaAiAddressEstablishment::findOrFail($id)->delete();
        return redirect()->route('addresses.index')
                         ->with('success','Address deleted.');
    }
}
