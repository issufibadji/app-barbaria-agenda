<?php

namespace Modules\AgendaAi\Entities;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AgendaAi\Database\factories\AgendaAiEstablishmentFactory;

class AgendaAiEstablishment extends Model
{
    use HasFactory;
    use Uuid;

    protected $table = 'agendaai_establishments';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'uuid',
        'name',
        'link',
        'descrition',
        'image',
        'user_id',
    ];

    protected static function newFactory()
    {
        return AgendaAiEstablishmentFactory::new();
    }

    public function services()
    {
      return $this->hasMany(AgendaAiService::class, 'establishment_id');

    }

    public function products()
    {
      return $this->hasMany(AgendaAiProduct::class, 'establishment_id');
    }
}
