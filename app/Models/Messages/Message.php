<?php

namespace App\Models\Messages;

use App\Models\Access\User\User;
use App\Models\Wishes\Wish;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';

    protected $fillable = [
        'message',
        'user_id',
        'wish_id',
        'agent_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wish()
    {
        return $this->belongsTo(Wish::class);
    }
}
