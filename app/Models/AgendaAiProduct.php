<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AgendaAiEstablishment;

class AgendaAiProduct extends Model
{
    use HasFactory;
    use Uuid;

    protected $table = 'agendaai_products';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'uuid',
        'name',
        'price',
        'user_id',
        'image',
        'descrition',
    ];


    public function establishment()
    {
      return $this->belongsTo(AgendaAiEstablishment::class, 'establishment_id');
    }
}
