<?php

namespace Modules\AgendaAi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgendaAiMessage extends Model
{
    use HasFactory;

    protected $table = 'agendaai_messages';

    protected $fillable = [
        'type',
        'message',
        'establishment_id',
    ];

    public function establishment()
    {
        return $this->belongsTo(AgendaAiEstablishment::class, 'establishment_id', 'id');
    }
}
