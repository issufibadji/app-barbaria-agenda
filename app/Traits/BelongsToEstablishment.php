<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\AgendaAiEstablishment;

trait BelongsToEstablishment
{
    protected static function bootBelongsToEstablishment()
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

            if ($user->hasRole('master')) {
                $ids = AgendaAiEstablishment::where('user_id', $user->id)->pluck('id');
                $builder->whereIn($builder->getModel()->getTable().'.establishment_id', $ids);
                return;
            }

            if ($user->hasAnyRole(['admin', 'professional'])) {
                $builder->where($builder->getModel()->getTable().'.establishment_id', $user->establishment_id);
            }
        });
    }
}
