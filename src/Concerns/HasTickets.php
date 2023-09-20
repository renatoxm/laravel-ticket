<?php

namespace Renatoxm\LaravelTicket\Concerns;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Renatoxm\LaravelTicket\Support\Config;

trait HasTickets
{
    /**
     * Get tickets relationship.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Config::ticketModelClass(), 'user_id');
    }
}
