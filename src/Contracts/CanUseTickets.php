<?php

namespace Renatoxm\LaravelTicket\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface CanUseTickets
{
    public function tickets(): HasMany;
}