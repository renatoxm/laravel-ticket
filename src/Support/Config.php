<?php

namespace Renatoxm\LaravelTicket\Support;

use Renatoxm\LaravelTicket\Models\Category;
use Renatoxm\LaravelTicket\Models\Comment;
use Renatoxm\LaravelTicket\Models\Label;
use Renatoxm\LaravelTicket\Models\Ticket;

class Config
{
    /**
     * @return class-string<Category>
     */
    public static function categoryModelClass(): string
    {
        return config('laravel_ticket.model.category');
    }

    /**
     * @return class-string<Label>
     */
    public static function labelModelClass(): string
    {
        return config('laravel_ticket.model.label');
    }

    /**
     * @return class-string<Comment>
     */
    public static function commentModelClass(): string
    {
        return config('laravel_ticket.model.comment');
    }

    /**
     * @return class-string<Ticket>
     */
    public static function ticketModelClass(): string
    {
        return config('laravel_ticket.model.ticket');
    }
}
