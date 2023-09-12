<?php

namespace Renatoxm\LaravelTicket\Enums;

enum Status: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case ARCHIVED = 'archived';
}
