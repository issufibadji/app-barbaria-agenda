<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AgendaAiService;
use App\Models\AgendaAiClient;

class AgendaAiAppointment extends Model
{
    use HasFactory;

    protected $table = 'agendaai_appointments';
    protected $fillable = [
        'service_id',
        'client_id',
        'scheduled_at',
        'status',
    ];


    public function service()
    {
        return $this->belongsTo(AgendaAiService::class, 'service_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(AgendaAiClient::class, 'client_id', 'id');
    }
}
