<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AgendaAiEstablishment;
use App\Traits\BelongsToEstablishment;

class AgendaAiMessage extends Model
{
    use HasFactory, BelongsToEstablishment;

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
