<?php

namespace Renatoxm\LaravelTicket\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Renatoxm\LaravelTicket\Support\Config;

trait HasAssignedTickets
{
    /**
     * Get Assigned Model tickets relationship.
     */
    public function assignedtickets(): MorphToMany
    {
        return $this->morphToMany(Config::ticketModelClass(), 'ticketable');
    }
}
