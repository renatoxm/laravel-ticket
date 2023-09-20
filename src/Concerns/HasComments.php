<?php

namespace Renatoxm\LaravelTicket\Concerns;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Renatoxm\LaravelTicket\Support\Config;

trait HasComments
{
    /**
     * Get User tickets relationship.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Config::commentModelClass(), 'user_id');
    }
}
