<?php

namespace Renatoxm\LaravelTicket\Contracts;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Renatoxm\LaravelTicket\Models\Ticket;

abstract class TicketEvent
{
    use Dispatchable;
    use SerializesModels;

    public $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }
}
