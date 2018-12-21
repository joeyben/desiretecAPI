<?php 

namespace App\Models\Access\User\Traits;

use Mail;
use App\Mail\TokenLoginRequested;
use App\Models\Access\User\UserToken;

trait TokenAuthenticable
{

    public function storeToken()
    {
        $this->token()->delete();

        $this->token()->create([
            'token' => str_random(15),
        ]);

        return $this;
    }

    public function sendTokenLink(array $options)
    {
        Mail::to($this)->send(new TokenLoginRequested($this, $options));
    }

    public function token()
    {
        return $this->hasOne(UserToken::class);
    }
}