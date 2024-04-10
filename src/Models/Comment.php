<?php

namespace Renatoxm\LaravelTicket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Renatoxm\LaravelTicket\Traits\HasPackageFactory;

/**
 * Renatoxm\LaravelTicket\Models\Comment.
 *
 * @property int $user_id
 * @property string $comment
 */
class Comment extends Model
{
    use HasPackageFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * Get Ticket RelationShip.
     */
    public function ticket(): BelongsTo
    {
        $tableName = config('laravel_ticket.table_names.comments', 'comments');

        return $this->belongsTo(
            Ticket::class,
            $tableName['columns']['ticket_foreign_id']
        );
    }

    /**
     * Get Message Relationship.
     */
    public function user(): BelongsTo
    {
        $tableName = config('laravel_ticket.table_names.comments', 'comments');

        return $this->belongsTo(
            config('auth.providers.users.model'),
            $tableName['columns']['user_foreign_id']
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
            'laravel_ticket.table_names.comments.table',
            parent::getTable()
        );
    }
}
