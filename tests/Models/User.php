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
use Renatoxm\LaravelTicket\Concerns\HasTickets;
use Renatoxm\LaravelTicket\Contracts\CanUseTickets;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, CanUseTickets
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use HasFactory;
    use HasTickets;
    use MustVerifyEmail;

    protected $guarded = [];
}
