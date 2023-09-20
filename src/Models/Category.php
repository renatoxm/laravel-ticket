<?php

namespace Renatoxm\LaravelTicket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Renatoxm\LaravelTicket\Concerns\HasVisibility;
use Renatoxm\LaravelTicket\Traits\HasPackageFactory;

class Category extends Model
{
    use HasPackageFactory;
    use HasVisibility;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * Get Tickets RelationShip.
     */
    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class);
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config(
            'laravel_ticket.table_names.categories',
            parent::getTable()
        );
    }
}
