<?php
namespace Modules\AgendaAi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgendaAiAddressEstablishment extends Model
{
    use HasFactory;

    protected $table = 'agendaai_address_establishments';
    protected $fillable = [
        'cep', 'uf', 'city', 'street', 'complement', 'establishment_id'
    ];

    public function establishment()
    {
        return $this->belongsTo(AgendaAiEstablishment::class, 'establishment_id', 'id');
    }
}
