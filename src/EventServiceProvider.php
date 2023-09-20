<?php

namespace Renatoxm\LaravelTicket;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Renatoxm\LaravelTicket\Events\TicketUpdated;
use Renatoxm\LaravelTicket\Listeners\UpdatePostTitle;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TicketCreated::class => [
            UpdatePostTitle::class,
        ],
        TicketUpdated::class => [
            UpdatePostTitle::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
