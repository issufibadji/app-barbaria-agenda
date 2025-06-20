<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\AgendaAiEstablishment;

trait BelongsToEstablishment
{
    /**
     * Column name used to scope by establishment.
     * Models may override by defining ESTABLISHMENT_COLUMN constant.
     */
    protected static string $defaultColumn = 'establishment_id';

    protected static function bootBelongsToEstablishment(): void
    {
        static::addGlobalScope('establishment', function (Builder $builder) {
            if (app()->runningInConsole()) {
                return;
            }

            $user = Auth::user();
            if (! $user) {
                return;
            }

            if ($user->hasRole('super-master')) {
                return;
            }

            $model   = $builder->getModel();
            $column  = defined(get_class($model) . '::ESTABLISHMENT_COLUMN')
                ? constant(get_class($model) . '::ESTABLISHMENT_COLUMN')
                : self::$defaultColumn;
            $qualified = $builder->qualifyColumn($column);

            if ($user->hasRole('master')) {
                $ids = AgendaAiEstablishment::where('user_id', $user->id)->pluck('id');
                $builder->whereIn($qualified, $ids);
                return;
            }

            if ($user->hasAnyRole(['admin', 'professional'])) {
                $builder->where($qualified, $user->establishment_id);
            }
        });
    }
}
