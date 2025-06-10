<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgendaAiPlan extends Model
{
    use HasFactory;

    protected $table = 'agendaai_plans';

    protected $fillable = [
        'name',
        'days',
        'active',
        'price',
        'descrition',
    ];
}
