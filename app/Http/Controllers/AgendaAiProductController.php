<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\AgendaAiProduct;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AgendaAiProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {

        $products = AgendaAiProduct::orderBy('created_at', 'desc')
                                ->latest()
                                ->paginate(15);;
        return Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return Inertia::render('Products/Create');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'descrition' => 'required|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $validated;
        $data['user_id'] = auth()->id();

        // Upload da imagem, se houver
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        AgendaAiProduct::create($data);

        return redirect()->route('products.index')
                         ->with('success', 'Produto criado com sucesso.');
    }

    /**
     * Display the specified product.
     */
    public function show(string $uuid)
    {
        $product = AgendaAiProduct::findOrFail($uuid);
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'mode' => 'show'
        ]);
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(string $uuid)
    {
        $product = AgendaAiProduct::findOrFail($uuid);
        return Inertia::render('Products/Edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, string $uuid): RedirectResponse
    {
        $product = AgendaAiProduct::findOrFail($uuid);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'descrition' => 'required|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')
                         ->with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(string $uuid): RedirectResponse
    {
        $product = AgendaAiProduct::findOrFail($uuid);
        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Produto excluído com sucesso.');
    }
}
