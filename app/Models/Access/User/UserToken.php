<?php

namespace App\Models\Access\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $table = 'user_tokens';

    protected $fillable = [
        'token'
    ];

    public function belongsToEmail($email) 
    {
        return (bool) ($this->user->Where('email', $email)->count() === 1);
    }

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
