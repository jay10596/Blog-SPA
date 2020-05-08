<?php

namespace App\Listeners;

use App\Events\FavouriteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FavouriteEventListener
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
     * @param  FavouriteEvent  $event
     * @return void
     */
    public function handle(FavouriteEvent $event)
    {
        //
    }
}
