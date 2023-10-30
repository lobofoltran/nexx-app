<?php

namespace App\Observers;
use Illuminate\Database\Eloquent\Model;

class OwnerObserver
{
    public function creating(Model $model)
    {
        if (auth()->check()) {
            $model->owner_id = auth()->user()->enterprise_id;
        } else if (env('APP_ENV') == 'testing') {
            $model->owner_id = '9999';
        }
    }
}
