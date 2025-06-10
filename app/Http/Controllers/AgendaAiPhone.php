<?php

namespace Modules\AgendaAi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgendaAiPhone extends Model
{
    use HasFactory;

    protected $table = 'agendaai_phones';
    protected $fillable = [
        'ddi',
        'ddd',
        'phone',
        'professional_id',
        'establishment_id',
    ];

    public function professional() {
    return $this->belongsTo(AgendaAiProfessional::class, 'professional_id');
    }

    public function establishment() {
        return $this->belongsTo(AgendaAiEstablishment::class, 'establishment_id', 'id');
    }

}
