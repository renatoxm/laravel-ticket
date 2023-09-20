<?php

namespace Renatoxm\LaravelTicket\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

interface CanHaveAssignedTickets
{
    public function assignedtickets(): MorphToMany;
}
