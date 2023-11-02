<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OwnerScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (auth()->user()) {
            $builder->where('owner_id', '=', auth()->user()->currentEnterprise()->id);
        } else if (env('APP_ENV') == 'testing') {
            $builder->where('owner_id', '=', '1');
        } else {
            // throw new \Exception('Empresa do usuário não encontrada!');
        }
    }
}
