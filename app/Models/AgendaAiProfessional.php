<?php

namespace Modules\AgendaAi\Entities;

use App\Models\User;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AgendaAi\Database\factories\AgendaAiProfessionalFactory;
use Modules\AgendaAi\Entities\AgendaAiEstablishment;
use Modules\AgendaAi\Entities\AgendaAiPhone;
use Modules\AgendaAi\Entities\AgendaAiService;
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

    protected static function newFactory()
    {
        return AgendaAiProfessionalFactory::new();
    }

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
