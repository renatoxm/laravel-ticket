<?php

namespace Renatoxm\LaravelTicket\Contracts;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Renatoxm\LaravelTicket\Models\Ticket;

abstract class TicketEvent
{
    use Dispatchable, SerializesModels;

    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }
}
