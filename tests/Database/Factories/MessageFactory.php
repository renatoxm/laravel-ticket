<?php

namespace Renatoxm\LaravelTicket\Tests\Database\Factories;

use Renatoxm\LaravelTicket\Models\Message;
use Renatoxm\LaravelTicket\Models\Ticket;
use Renatoxm\LaravelTicket\Tests\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition()
    {
        $tableName = config('laravel_ticket.table_names.messages', 'messages');

        return [
            'user_id' => User::factory(),
            $tableName['columns']['ticket_foreing_id'] => Ticket::factory(),
            'message' => $this->faker->paragraph(2),
        ];
    }
}