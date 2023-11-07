<?php

namespace App\Observers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class OwnerObserver
{
    public function creating(Model $model)
    {
        if (auth()->check()) {
            $model->owner_id = auth()->user()->currentEnterprise()->id;
        } else if (env('APP_ENV') == 'testing') {
            $model->owner_id = '1';
        } else if (Session::get('costumer')) {
            $model->owner_id = Session::get('costumer')['data']->owner_id;
        }
    }
}
