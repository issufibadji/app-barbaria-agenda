<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgendaAiMessageSetting extends Model
{
    use HasFactory;

    protected $table = 'agenda_ai_message_settings';

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
