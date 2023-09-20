<?php

namespace Renatoxm\LaravelTicket\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Renatoxm\LaravelTicket\Models\Ticket;
use Renatoxm\LaravelTicket\Tests\Models\User;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'user_id' => User::factory(),
            'title' => $this->faker->title(),
            'message' => $this->faker->paragraph(2),
            'priority' => $this->faker->randomElement(['low', 'normal', 'high']),
            'status' => $this->faker->randomElement(['open', 'closed']),
            'is_resolved' => $this->faker->randomElement([true, false]),
            'is_locked' => $this->faker->randomElement([true, false]),
        ];
    }
}
