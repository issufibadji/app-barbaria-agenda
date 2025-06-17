<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait Uuid
{
    /**
     * Boot the trait and assign a UUID when creating a new model instance.
     */
    protected static function bootUuid(): void
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Initialize the trait for an instance.
     */
    public function initializeUuid(): void
    {
        $this->incrementing = false;
        $this->keyType = 'string';
    }
}
