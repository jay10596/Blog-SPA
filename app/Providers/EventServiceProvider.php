<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'App\Events\RemoveLikeEvent' => [
            'App\Listeners\RemoveLikeEventListener',
        ],

        'App\Events\RemoveReplyEvent' => [
            'App\Listeners\RemoveReplyEventListener',
        ],

        'App\Events\FavouriteEvent' => [
            'App\Listeners\FavouriteEventListener',
        ],
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
