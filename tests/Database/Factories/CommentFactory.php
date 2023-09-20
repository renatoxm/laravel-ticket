<?php

namespace Renatoxm\LaravelTicket\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Renatoxm\LaravelTicket\Models\Comment;
use Renatoxm\LaravelTicket\Models\Ticket;
use Renatoxm\LaravelTicket\Tests\Models\User;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        $tableName = config('laravel_ticket.table_names.comments', 'comments');

        return [
            'user_id' => User::factory(),
            $tableName['columns']['ticket_foreing_id'] => Ticket::factory(),
            'comment' => $this->faker->paragraph(2),
        ];
    }
}
