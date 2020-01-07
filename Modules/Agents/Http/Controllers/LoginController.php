<?php

namespace Modules\Agents\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function switch(int $id)
    {
        Auth::guard('agent')->logout();
        Auth::guard('agent')->loginUsingId($id, true);

        return redirect()->back();
    }
}
