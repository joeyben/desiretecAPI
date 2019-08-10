<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\Access\User\User;
use Illuminate\Http\Request;

class TokenAuthentication
{
    protected $request;
    protected $identifier = 'email';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function requestLink()
    {
        logger()->info('TokenAuthentication.php > requestLink > request: '. $this->request->get($this->identifier));
        $user = $this->getUserByIdentifier($this->request->get($this->identifier));
        logger()->info('TokenAuthentication.php > requestLink > user: '. $user);

        $user->storeToken()->sendTokenLink([
            'email'    => $user->email,
        ]);
    }

    protected function getUserByIdentifier($value)
    {
        return User::where($this->identifier, $value)->firstOrFail();
    }
}
