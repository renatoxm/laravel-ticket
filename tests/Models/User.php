<?php

namespace Renatoxm\LaravelTicket\Tests\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Renatoxm\LaravelTicket\Concerns\HasAssignedTickets;
use Renatoxm\LaravelTicket\Concerns\HasTickets;
use Renatoxm\LaravelTicket\Concerns\HasComments;
use Renatoxm\LaravelTicket\Contracts\CanOwnTickets;
use Renatoxm\LaravelTicket\Contracts\CanHaveAssignedTickets;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanOwnTickets, CanHaveAssignedTickets
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use HasFactory;
    use HasTickets;
    use HasAssignedTickets;
    use HasComments;
    use MustVerifyEmail;

    protected $guarded = [];
}
