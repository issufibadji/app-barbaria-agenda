<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AgendaAiClient extends Model
{
    use HasFactory, HasUuids;

    // Se sua PK for 'uuid' em vez de 'id'
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

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
