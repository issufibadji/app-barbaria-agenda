<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AgendaAiProfessional;
class AgendaAiService extends Model
{
    use HasFactory;
    use Uuid;

    protected $table      = 'agendaai_services';
    protected $primaryKey = 'uuid';
    public $incrementing  = false;
    protected $keyType    = 'string';

    protected $fillable = [
        'uuid','name','duration_min','price','user_id','image','descrition',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function professionals()
    {
        return $this->belongsToMany(
            AgendaAiProfessional::class,
            'agendaai_service_professional',
            'service_id',
            'professional_id',
            'id',
            'id'
        )->withTimestamps();
    }
}
