<?php

namespace Modules\Agents\Http\Controllers;

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
