<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\AgendaAiPayment;
use App\Models\AgendaAiPlan;
use App\Models\AgendaAiEstablishment;
use App\Models\MercadoPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule; //Temporaria para alimentar apagem
use App\Http\Controllers\MercadoPagoController;
use Inertia\Inertia;

class AgendaAiPaymentController extends Controller
{
    public function index()
    {
        $payments = AgendaAiPayment::with([
            'plan',
            'establishment',
            'mercadoPayment',
        ])->orderBy('created_at', 'desc')->get();

        return Inertia::render('Payments/Index', [
            'payments' => $payments,
        ]);
    }


    public function create()
    {
        $plans            = AgendaAiPlan::pluck('name', 'id');
        $establishments   = AgendaAiEstablishment::pluck('name', 'id');
        $mercadoPayments  = MercadoPayment::pluck('id_mp', 'id');
        $payment          = new AgendaAiPayment();

        return Inertia::render('Payments/Create', [
            'plans' => $plans,
            'establishments' => $establishments,
            'mercadoPayments' => $mercadoPayments,
            'payment' => $payment,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $staticPayments = ['abc123', 'def456', 'ghi789']; // temporaria para alimentar pagamento

        $validated = $request->validate([
            'plan_id'             => 'required|exists:agendaai_plans,id',
            'establishment_id'    => 'required|exists:agendaai_establishments,id',
            // 'mercado_payment_id'  => 'required|exists:mercado_payments,id',
            'mercado_payment_id' => 'required|string|max:50',
        ]);

        AgendaAiPayment::create($validated);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Pagamento vinculado com sucesso.');
    }

    public function edit(int $id)
    {
        $payment = AgendaAiPayment::findOrFail($id);
        $plans = AgendaAiPlan::pluck('name', 'id');
        $establishments = AgendaAiEstablishment::pluck('name', 'id');
        $mercadoPayments  = MercadoPayment::pluck('id_mp', 'id');

        return Inertia::render('Payments/Edit', [
            'payment' => $payment,
            'plans' => $plans,
            'establishments' => $establishments,
            'mercadoPayments' => $mercadoPayments,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $payment = AgendaAiPayment::findOrFail($id);

        $validated = $request->validate([
            'plan_id'             => 'required|exists:agendaai_plans,id',
            'establishment_id'    => 'required|exists:agendaai_establishments,id',
            // 'mercado_payment_id'  => 'required|exists:mercado_payments,id',
            'mercado_payment_id' => 'required|string|max:50',
        ]);

        $payment->update($validated);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Pagamento atualizado com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        AgendaAiPayment::destroy($id);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Pagamento desvinculado com sucesso.');
    }

    public function generatePayment($plano)
    {
        $dados = [
            'valor' => '0.00',
            'identificador' => Auth::user()->id,
            'plano' => '',
        ];

        $plan = AgendaAiPlan::where('id', '=', $plano)->first();

        if (!$plan) {
            Session::flash('error', 'O Plano selecionado não existe.');
            return redirect()->back()->withInput();
        }

        $dados['valor'] = $plan->price;
        $dados['plano'] = $plan->descrition;

        $payment = MercadoPayment::join('users', 'mercado_payments.id_user', '=', 'users.id')
            ->where('mercado_payments.valor', $dados['valor'])
            ->where('mercado_payments.status', 'pendente')
            ->where('users.id', Auth::user()->id)
            ->select('mercado_payments.*')
            ->first();

        if ($payment) {
            return redirect()->to(url('agendaai/repayment/' . $payment->id));
        } else {
            $request = new Request();
            $request = $request->merge([
                'dados' => [
                    'identificador'     => Auth::user()->id,
                    'plano'             => $dados['plano'],
                    'valor'             => $dados['valor']
                ],
                'formData' => [
                    'payment_method_id'  => 'pix',
                    'transaction_amount' => $dados['valor'],
                    'payer'              => ['email' => Auth::user()->email]
                ],
            ]);


            $mp = new MercadoPagoController();

            $response = $mp->processPayment($request);

            if ($response->isSuccessful()) {
                $payment = MercadoPayment::join('users', 'mercado_payments.id_user', '=', 'users.id')
                    ->where('mercado_payments.valor', $dados['valor'])
                    ->where('mercado_payments.status', 'pendente')
                    ->where('users.id', Auth::user()->id)
                    ->select('mercado_payments.*')
                    ->first();
                if ($payment) {
                    return redirect()->to(url('agendaai/repayment/' . $payment->id));
                } else {
                    Session::flash('error', 'Pagamento não encontrado.');
                    return redirect()->back()->withInput();
                }
            } else {
                Session::flash('error', 'Erro ao criar o Pagamento.');
                return redirect()->back()->withInput();
            }
        }
    }

    public function listPayments()
    {
        $payments = AgendaAiPayment::with([
            'plan',
            'establishment',
            'mercadoPayment',
        ])->orderBy('created_at', 'desc')->get();

        return Inertia::render('Payments/List', [
            'payments' => $payments,
        ]);
    }
}
