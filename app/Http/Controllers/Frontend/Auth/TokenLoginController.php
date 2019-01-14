<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Access\User\UserToken;
use Auth;
use Illuminate\Http\Request;

class TokenLoginController extends Controller
{
    protected $redirectOnRequested = '/login/token';

    public function show()
    {
        return view('frontend.auth.tokenlogin');
    }

    public function sendToken(Request $request, TokenAuthentication $auth)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255|exists:users,email'
        ]);

        $auth->requestLink();

        return redirect()->to($this->redirectOnRequested)->with('success', 'We\'ve sent you a login link!');
    }

    public function validateToken(Request $request, UserToken $token)
    {
        $token->delete();

        if ($token->isExpired()) {
            return redirect('/login/token')->with('error', 'That login link has expired.');
        }

        if (!$token->belongsToEmail($request->email)) {
            return redirect('/login/token')->with('error', 'Invalid login link!');
        }

        Auth::login($token->user, $request->remember);

        return redirect()->intended();
    }
}
