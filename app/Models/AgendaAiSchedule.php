<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AgendaAiProfessional;

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
        // The schedules table stores the professional_id referencing the
        // numeric `id` column of AgendaAiProfessional, but the model's
        // primary key is a UUID. Specify the owner key so the relationship
        // works correctly.
        return $this->belongsTo(AgendaAiProfessional::class, 'professional_id', 'id');
    }
}
