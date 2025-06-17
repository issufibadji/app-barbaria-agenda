<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaAiMessageSetting extends Model
{
    protected $fillable = [
        'establishment_id',
        'type',
        'message',
    ];

    public function establishment()
    {
        return $this->belongsTo(AgendaAiEstablishment::class);
    }
}
