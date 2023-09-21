<?php

use Renatoxm\LaravelTicket\Models\Category;
use Renatoxm\LaravelTicket\Models\Label;
use Renatoxm\LaravelTicket\Models\Ticket;
use Renatoxm\LaravelTicket\Models\User;

it('creates a ticket with its associated user', function () {
    $user = User::factory()->create();

    Ticket::factory()->create([
        'title' => 'IT Support',
        'user_id' => $user->id,
    ]);

    $this->assertEquals($user->tickets()->count(), 1);
    $this->assertEquals($user->tickets()->first()->title, 'IT Support');
});

it('creates a ticket with its associated assignees', function () {
    $user = User::factory()->create();
    $ticket = Ticket::factory()->create();

    // $ticket->userassignedtickets()->attach($user); // wont work in this test because User test model is not the same as the config('auth.providers.users.model')
    $user->assignedtickets()->attach($ticket);

    // $entries = DB::table('ticketables')->get();

    // $var = '';

    // foreach ($entries as $entry) {

    //     $id = $entry->ticketable_id;
    //     $type = $entry->ticketable_type;
    //     $ticket = $entry->ticket_id;
    //     $var .= '//' . $id . '++' . $type . '++' . $ticket . '\\';
    // }

    // dump($var);

    $this->assertEquals($user->assignedtickets()->count(), 1);
});

it('get user assigned tickets', function () {
    $tickets = Ticket::factory()->count(5)->create();
    $user = User::factory()->create();

    foreach ($tickets as $ticket) {
        // $ticket->userassignedtickets()->attach($user); // wont work in this test because User test model is not the same as the config('auth.providers.users.model')
        $user->assignedtickets()->attach($ticket);
    }

    $this->assertEquals($user->assignedtickets()->count(), 5);
});

it('associates labels to a ticket', function () {
    $labels = Label::factory()->times(3)->create();
    $ticket = Ticket::factory()->create();

    $ticket->attachLabels($labels->pluck('id'));

    $this->assertEquals($ticket->labels->count(), 3);
});

it('sync labels to a ticket', function () {
    $labels = Label::factory()->times(2)->create();
    $ticket = Ticket::factory()->create();

    $ticket->syncLabels($labels->pluck('id'));

    $this->assertEquals($ticket->labels->count(), 2);
});

it('sync labels to a ticket without detaching', function () {
    $labels = Label::factory()->times(3)->create();
    $ticket = Ticket::factory()->create();
    $ticket->attachLabels($labels->pluck('id'));

    $anotherlabels = Label::factory()->times(2)->create();

    $ticket->syncLabels($anotherlabels->pluck('id'), false);

    $this->assertEquals($ticket->labels->count(), 5);
});

it('associates categories to a ticket', function () {
    $categories = Category::factory()->times(3)->create();
    $ticket = Ticket::factory()->create();

    $ticket->attachCategories($categories->pluck('id'));

    $this->assertEquals($ticket->categories->count(), 3);
});

it('sync categories to a ticket', function () {
    $categories = Category::factory()->times(2)->create();
    $ticket = Ticket::factory()->create();

    $ticket->syncCategories($categories->pluck('id'));

    $this->assertEquals($ticket->categories->count(), 2);
});

it('sync categories to a ticket without detaching', function () {
    $categories = Category::factory()->times(3)->create();
    $ticket = Ticket::factory()->create();
    $ticket->attachCategories($categories->pluck('id'));

    $anotherCategories = Category::factory()->times(2)->create();

    $ticket->syncCategories($anotherCategories->pluck('id'), false);

    $this->assertEquals($ticket->categories->count(), 5);
});

it('can create a comment inside the ticket by authenticated user', function () {
    $this->actingAs(User::factory()->create());

    $ticket = Ticket::factory()->create();

    $ticket->comment('How are you today?');

    $this->assertEquals($ticket->comments->count(), 1);
});

it('can create a comment inside the ticket by another user', function () {
    $this->actingAs($user = User::factory()->create());

    $anotherUser = User::factory()->create();
    $ticket = Ticket::factory()->create();

    $ticket->commentAsUser($anotherUser, 'How are you today?');

    $this->assertEquals($ticket->comments->count(), 1);
    $this->assertEquals($ticket->comments->first()->user_id, $anotherUser->id);
});

it('associate a comment ticket to the current user, if no user are defined', function () {
    $this->actingAs($user = User::factory()->create());

    $ticket = Ticket::factory()->create();

    $ticket->commentAsUser(null, 'How are you today?');

    $this->assertEquals($ticket->comments->count(), 1);
    $this->assertEquals($ticket->comments->first()->user_id, $user->id);
});