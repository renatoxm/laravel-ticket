<?php

use Renatoxm\LaravelTicket\Models\Comment;
use Renatoxm\LaravelTicket\Models\Ticket;

it('can store a comment', function () {
    $ticket = Ticket::factory()->create([
        'title' => 'Laravel is cool!',
    ]);

    $tableName = config(
        'laravel_ticket.table_names.comments',
        'comments'
    );

    $comment = Comment::factory()
        ->create([
            $tableName['columns']['ticket_foreing_id'] => $ticket->id,
            'comment' => 'Comment from a ticket',
        ]);

    $this->assertDatabaseHas($tableName['table'], [
        $tableName['columns']['ticket_foreing_id'] => $ticket->id,
        'comment' => 'Comment from a ticket',
    ]);

    $this->assertEquals($comment->count(), 1);
    $this->assertEquals($comment->ticket->title, 'Laravel is cool!');
});
