<?php

namespace App\Observers;

use App\Models\Card;
use Illuminate\Support\Facades\App;

class CardObserver
{
    public function creating(Card $card)
    {
        $card->owner_id = env('APP_ENV') == 'testing' ? '9999' : auth()->user()->enterprise_id;
    }

    /**
     * Handle the Card "created" event.
     */
    public function created(Card $card): void
    {
        //
    }

    /**
     * Handle the Card "updated" event.
     */
    public function updated(Card $card): void
    {
        //
    }

    /**
     * Handle the Card "deleted" event.
     */
    public function deleted(Card $card): void
    {
        //
    }

    /**
     * Handle the Card "restored" event.
     */
    public function restored(Card $card): void
    {
        //
    }

    /**
     * Handle the Card "force deleted" event.
     */
    public function forceDeleted(Card $card): void
    {
        //
    }
}
