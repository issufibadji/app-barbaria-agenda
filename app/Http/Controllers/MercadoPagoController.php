<?php

namespace Modules\MercadoPago\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use MercadoPago\Payment;
use MercadoPago\SDK;
use Modules\MercadoPago\Entities\MercadoPayment;
use Modules\MercadoPago\Events\MPProcessWebHook;

class MercadoPagoController extends Controller
{

    public function processPayment(Request $request)
    {

        SDK::setAccessToken(env('ACCESS_TOKEN_MP'));

        $payment = new Payment();
        $payment->transaction_amount = $request->input('formData.transaction_amount');
        $payment->payment_method_id = $request->input('formData.payment_method_id');
        $payment->payer = array(
            "email" => $request->input('formData.payer.email'),
        );
        
        //Salvando o pagamento
        $mercadoPago = MercadoPayment::create([
            'valor' => $request->input('dados.valor'),
            'status' => 'criado',
            'metodo_pagamento' => 'PIX',
            'id_user' => is_null(Auth::id()) ? '0' : Auth::id(),
            'module' => $request->input('dados.modulo'),
            'id_module' => $request->input('dados.identificador'),
            'data_pagamento' => null,
        ]);

        if ($payment->save()) {

            $mercadoPago->id_mp = $payment->id;
            $mercadoPago->status_detail = $payment->status_detail;

            switch ($payment->status) {
                case 'authorized':
                case 'in_process':
                case 'pending':
                    $mercadoPago->status = 'pendente';
                    break;
                case 'approved':
                    $mercadoPago->status = 'aprovado';
                    break;
                default:
                    $mercadoPago->status = 'cancelado';
                    break;
            }

            $retorno = [];
            $retorno['qr_code'] = $payment->point_of_interaction->transaction_data->qr_code;
            $retorno['ticket_url'] = $payment->point_of_interaction->transaction_data->ticket_url;
            $retorno['qr_code_base64'] = $payment->point_of_interaction->transaction_data->qr_code_base64;


            $mercadoPago->qr_code = $payment->point_of_interaction->transaction_data->qr_code;
            $mercadoPago->save();

            Debugbar::disable();
            return response(json_encode($retorno), 200);
        } else {
            $mercadoPago->status = 'falha';
            $mercadoPago->save();

            Debugbar::disable();
            return response('', 500);
        }
    }

    public function processWebHook(Request $request)
    {
        $type = $request->input('type');
        $data = $request->input('data');

        SDK::setAccessToken(env('ACCESS_TOKEN_MP'));

        if ($type == "payment") {

            $response = new Payment();
            $payment = $response->find_by_id($data['id']);

            $mercadoPago = MercadoPayment::where('id_mp', $payment->id)->first();

            if ($mercadoPago) {

                $mercadoPago->valor_pago = $payment->transaction_amount;
                $mercadoPago->status_detail = $payment->status_detail;

                switch ($payment->status) {
                    case 'authorized':
                    case 'in_process':
                    case 'pending':
                        $mercadoPago->status = 'pendente';
                        $mercadoPago->save();
                        $mercadoPago->refresh();

                        break;
                    case 'approved':
                        if($mercadoPago->status != 'aprovado'){
                            $mercadoPago->status = 'aprovado';
                            $mercadoPago->data_pagamento = date('Y-m-d H:i:s');
                            $mercadoPago->save();
                            $mercadoPago->refresh();

                            event(new MPProcessWebHook($mercadoPago));
                        }

                        break;
                    default:
                        $mercadoPago->status = 'cancelado';
                        $mercadoPago->save();
                        $mercadoPago->refresh();

                        break;
                }
            }
        }

        return response('', 201);
    }
}
