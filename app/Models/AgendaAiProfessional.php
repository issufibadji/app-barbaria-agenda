<?php

namespace App\Models;

use App\Models\User;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AgendaAiEstablishment;
use App\Models\AgendaAiPhone;
use App\Models\AgendaAiService;
class AgendaAiProfessional extends Model
{
    use HasFactory, Uuid;

    protected $table = 'agendaai_professionals';

    protected $fillable = [
        'uuid',
        'user_id',
        'commission',
        'establishment_id',
    ];


    public function establishment()
    {

        return $this->belongsTo(AgendaAiEstablishment::class, 'establishment_id', 'id');
    }


    public function phones()
    {
        return $this->hasMany(AgendaAiPhone::class, 'professional_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function services()
    {
        return $this->belongsToMany(
            AgendaAiService::class,
            'agendaai_service_professional',
            'professional_id',
            'service_id',
            'id',
            'id'
        )->withTimestamps();
    }

}
