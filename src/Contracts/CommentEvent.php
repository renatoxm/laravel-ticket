<?php

namespace Renatoxm\LaravelTicket\Contracts;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Renatoxm\LaravelTicket\Models\Comment;

abstract class CommentEvent
{
    use Dispatchable, SerializesModels;

    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
