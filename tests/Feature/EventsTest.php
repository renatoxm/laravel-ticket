<?php

use Illuminate\Support\Facades\Event;
use Renatoxm\LaravelTicket\Events\TicketCreated;
// use Illuminate\Support\Facades\Queue;
// use Renatoxm\LaravelTicket\Listeners\QueueableListener;
use Renatoxm\LaravelTicket\Models\Ticket;

it('can fire events', function () {
    Event::fake();

    // Event::listen(TicketCreated::class, [TicketListener::class, 'handle']);
    Event::listen(function (TicketCreated $event) {
        dump($event->ticket->title);
    });

    $ticket = Ticket::factory()->create([
        'title' => 'this is a ticket',
    ]);

    // Event::assertDispatched(TicketCreated::class);
    Event::assertDispatched(TicketCreated::class, function ($event) use ($ticket) {
        return $event->ticket->uuid === $ticket->uuid;
    });
});
