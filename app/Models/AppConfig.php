<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // ✅ ESSA LINHA É NECESSÁRIA
use Illuminate\Support\Str;

class AppConfig extends Model
{
    protected $fillable = [
        'key',
        'value',
        'description',
        'path_archive',
        'extension',
        'required',
        'uuid',
    ];

    public $timestamps = false;

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
