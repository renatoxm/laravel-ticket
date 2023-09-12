<?php

use Renatoxm\LaravelTicket\Models\Label;
use Renatoxm\LaravelTicket\Models\Ticket;

it('can store a label', function () {
    $ticket = Ticket::factory()->create();

    $label = Label::factory()
        ->create([
            'name' => 'Support',
            'slug' => 'supoort',
        ]);

    $tableName = config(
        'laravel_ticket.table_names.labels',
        'labels'
    );

    $this->assertDatabaseHas($tableName, [
        'name' => 'Support',
        'slug' => 'supoort',
    ]);

    $this->assertEquals($label->count(), 1);
});
