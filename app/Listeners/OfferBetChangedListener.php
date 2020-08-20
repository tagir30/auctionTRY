<?php

namespace App\Listeners;

use App\Events\OfferBetChange;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OfferBetChangedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OfferBetChange  $event
     * @return void
     */
    public function handle(OfferBetChange $event)
    {
        //
    }
}
