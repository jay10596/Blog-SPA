<?php

namespace App\Listeners;

use App\Events\RemoveReplyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RemoveReplyEventListener
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
     * @param  RemoveReplyEvent  $event
     * @return void
     */
    public function handle(RemoveReplyEvent $event)
    {
        //
    }
}
