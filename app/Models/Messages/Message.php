<?php

namespace App\Models\Messages;

use Illuminate\Database\Eloquent\Model;
use App\Events\Frontend\Messages\MessageSent;

class Message extends Model
{
    protected $dispatchesEvents = [
        'created' => MessageSent::class
    ];

    protected $table = 'message';

    protected $fillable = [
        'message',
        'user_id',
        'wish_id'
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
