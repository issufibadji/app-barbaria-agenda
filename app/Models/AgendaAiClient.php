<?php

namespace Modules\AgendaAi\Entities;

use App\Models\User;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgendaAiClient extends Model
{
    use HasFactory, Uuid;

    protected $table = 'agendaai_clients';
    protected $fillable = [
        'uuid',
        'user_id',
        'gender',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
