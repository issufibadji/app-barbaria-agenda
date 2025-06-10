<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AgendaAiPlan;
use App\Models\AgendaAiEstablishment;
use App\Models\MercadoPayment;

class AgendaAiPayment extends Model
{
    use HasFactory;

    protected $table = 'agendaai_payments';

    protected $fillable = [
        'plan_id',
        'mercado_payment_id',
        'establishment_id',
    ];

    /**
     * Relação com o plano vinculado
     */
    public function plan()
    {
        return $this->belongsTo(AgendaAiPlan::class, 'plan_id');
    }

    /**
     * Relação com o pagamento no módulo MercadoPago
     */
    public function mercadoPayment()
    {
        return $this->belongsTo(MercadoPayment::class, 'mercado_payment_id');
    }

    /**
     * Relação com o estabelecimento
     */
    public function establishment()
    {
        return $this->belongsTo(AgendaAiEstablishment::class, 'establishment_id', 'id');
    }
}
