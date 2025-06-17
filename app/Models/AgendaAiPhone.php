<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AgendaAiProfessional;
use App\Models\AgendaAiEstablishment;

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
    return $this->belongsTo(AgendaAiProfessional::class, 'professional_id', 'id');
    }

    public function establishment() {
        return $this->belongsTo(AgendaAiEstablishment::class, 'establishment_id', 'id');
    }

}
