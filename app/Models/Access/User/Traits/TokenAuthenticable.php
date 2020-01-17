<?php

namespace App\Models\Access\User\Traits;

use App\Mail\ApiTokenLoginRequested;
use App\Mail\TokenLoginRequested;
use App\Models\Access\User\UserToken;
use Mail;

trait TokenAuthenticable
{
    public function storeToken()
    {
        if ($this->token()->exists()) {
            return $this;
        }
        $this->token()->create([
                'token' => str_random(15),
            ]);

        return $this;
    }

    public function sendTokenLink(array $options)
    {
        Mail::to($this)->send(new TokenLoginRequested($this, $options));
    }

    public function sendApiTokenLink(array $options)
    {
        Mail::to($this)->send(new ApiTokenLoginRequested($this, $options));
    }

    public function token()
    {
        return $this->hasOne(UserToken::class);
    }
}
