<?php

namespace Renatoxm\LaravelTicket\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Renatoxm\LaravelTicket\Concerns;
use Renatoxm\LaravelTicket\Events;
use Renatoxm\LaravelTicket\Scopes\TicketScope;

/**
 * Renatoxm\LaravelTicket\Models\Ticket.
 *
 * @property string $uuid
 * @property int    $owner_id
 * @property string $owner_type
 * @property string $title
 * @property string $message
 * @property string $priority
 * @property string $status
 * @property bool   $is_resolved
 * @property bool   $is_locked
 * @property int    $assigned_to
 */
class Ticket extends Model
{
    use Concerns\InteractsWithTicketRelations;
    use Concerns\InteractsWithTickets;
    use HasFactory;
    use TicketScope;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * Get Owner RelationShip.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    /**
     * Get tickets assigned to users polymorphic many-to-many RelationShip.
     */
    public function userassignedtickets(): MorphToMany
    {
        return $this->morphedByMany(config('auth.providers.users.model'), 'ticketable');
    }

    /**
     * Get Messages RelationShip.
     */
    public function comments(): HasMany
    {
        $table = config('laravel_ticket.table_names.comments', 'comments');

        return $this->hasMany(
            Comment::class,
            (string) $table['columns']['ticket_foreing_id'],
        );
    }

    /**
     * Get Categories RelationShip.
     */
    public function categories(): BelongsToMany
    {
        $table = config('laravel_ticket.table_names.category_ticket', 'category_ticket');

        return $this->belongsToMany(
            Category::class,
            $table['table'],
            $table['columns']['ticket_foreign_id'],
            $table['columns']['category_foreign_id'],
        );
    }

    /**
     * Get Labels RelationShip.
     */
    public function labels(): BelongsToMany
    {
        $table = config('laravel_ticket.table_names.label_ticket', 'label_ticket');

        return $this->belongsToMany(
            Label::class,
            $table['table'],
            $table['columns']['ticket_foreign_id'],
            $table['columns']['label_foreign_id'],
        );
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config(
            'laravel_ticket.table_names.tickets',
            parent::getTable()
        );
    }

    // https://laravel-news.com/laravel-model-events-getting-started
    protected $dispatchesEvents = [
        'saving'   => Events\TicketSaving::class,
        'saved'    => Events\TicketSaved::class,
        'creating' => Events\TicketCreating::class,
        'created'  => Events\TicketCreated::class,
        'updating' => Events\TicketUpdating::class,
        'updated'  => Events\TicketUpdated::class,
        'deleting' => Events\TicketDeleting::class,
        'deleted'  => Events\TicketDeleted::class,
    ];
}
