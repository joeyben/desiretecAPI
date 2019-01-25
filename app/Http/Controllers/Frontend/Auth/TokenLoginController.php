<?php

namespace App\Http\Controllers\Frontend\Auth;

use Auth;
use App\Models\Access\User\UserToken;
use App\Http\Controllers\Frontend\Auth\TokenAuthentication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        
        if (!$token->belongsToEmail($request->email)) {
            
            return redirect('/login/token')->with('error', 'Invalid login link!');
        }
        
        Auth::login($token->user, $request->remember);

        return redirect()->intended();
    }
}
