<?php

namespace Modules\Agents\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Agent extends Authenticatable
{
    use Notifiable;

    protected $guard = 'agent';

    public $guarded = [];

    protected $hidden = [
        'password', 'remember_token'
    ];
}
