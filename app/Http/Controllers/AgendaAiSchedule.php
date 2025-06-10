<?php

namespace Modules\AgendaAi\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AgendaAi\Entities\AgendaAiProfessional;

class AgendaAiSchedule extends Model
{
    use HasFactory;

    protected $table = 'agendaai_schedules';
    protected $fillable = [
        'schedule',
        'professional_id',
    ];

    public function professional()
    {
        return $this->belongsTo(AgendaAiProfessional::class, 'professional_id');
    }
}
