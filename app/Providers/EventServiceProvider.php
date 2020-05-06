<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'App\Events\LikeEvent' => [
            'App\Listeners\LikeEventListener',
        ],
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
