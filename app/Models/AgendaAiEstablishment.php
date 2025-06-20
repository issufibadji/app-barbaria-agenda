<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToEstablishment;
use Illuminate\Support\Str;
use App\Models\AgendaAiService;
use App\Models\AgendaAiProduct;
use App\Models\AgendaAiMessageSetting;
use App\Models\AgendaAiPhone;

class AgendaAiEstablishment extends Model
{
    use HasFactory;
    use Uuid;
    use BelongsToEstablishment;

    protected $table = 'agendaai_establishments';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'name',
        'link',
        'manual_chat_link',
        'descrition',
        'image',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->name = trim($model->name);
            $model->manual_chat_link = Str::slug($model->name);

            if (empty($model->link)) {
                $model->link = 'https://agenderbarber.app/chat/' . $model->manual_chat_link;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function services()
    {
        return $this->hasMany(AgendaAiService::class, 'establishment_id');
    }

    public function products()
    {
        return $this->hasMany(AgendaAiProduct::class, 'establishment_id');
    }

    public function messageSettings()
    {
        return $this->hasMany(AgendaAiMessageSetting::class, 'establishment_id');
    }

    public function phones()
    {
        return $this->hasMany(AgendaAiPhone::class, 'establishment_id');
    }
}
