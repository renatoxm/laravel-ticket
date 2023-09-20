<?php

namespace Renatoxm\LaravelTicket\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface CanOwnTickets
{
    public function tickets(): HasMany;
}
