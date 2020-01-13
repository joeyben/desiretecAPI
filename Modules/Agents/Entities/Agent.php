<?php

namespace Modules\Agents\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Agent  extends Authenticatable
{
    use Notifiable;

    protected $guard = 'agent';

    public $guarded = [];

    protected $hidden = [
        'password', 'remember_token'
    ];
}
