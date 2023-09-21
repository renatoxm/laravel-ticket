<?php

use Renatoxm\LaravelTicket\Models\Comment;
use Renatoxm\LaravelTicket\Models\Ticket;
use Renatoxm\LaravelTicket\Models\User;

it('can attach comment to a ticket', function () {
    $comment = Comment::factory()->create();
    $ticket = Ticket::factory()->create([
        'title' => 'Can you create a comment?',
    ]);

    $comment->ticket()->associate($ticket);

    $this->assertEquals($comment->ticket->title, 'Can you create a comment?');
});

it('comment can be associated to a user', function () {
    $user = User::factory()->create([
        'name' => 'Oussama',
    ]);

    $comment = Comment::factory()->create();

    $comment->user()->associate($user);

    $this->assertEquals($comment->user->name, 'Oussama');
});
