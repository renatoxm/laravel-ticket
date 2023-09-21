<?php

namespace Renatoxm\LaravelTicket\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Renatoxm\LaravelTicket\Concerns\HasAssignedTickets;
use Renatoxm\LaravelTicket\Concerns\HasComments;
use Renatoxm\LaravelTicket\Concerns\HasTickets;
use Renatoxm\LaravelTicket\Contracts\CanHaveAssignedTickets;
use Renatoxm\LaravelTicket\Contracts\CanOwnTickets;
use Renatoxm\LaravelTicket\Traits\HasPackageFactory;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanHaveAssignedTickets, CanOwnTickets
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use HasAssignedTickets;
    use HasComments;
    use HasPackageFactory;
    use HasTickets;
    use MustVerifyEmail;

    protected $guarded = [];
}