<?php

namespace App\Http\Composers;

use App\Models\Agents\Agent;
use App\Services\Flag\Src\Flag;
use Auth;
use Illuminate\View\View;

/**
 * Class GlobalComposer.
 */
class GlobalComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $agents = null;
        $loggedAvatar = null;
        $loggedAgent = null;

        if (Auth::guard('web')->check()) {
            $agents = Agent::where('user_id', Auth::guard('web')->user()->id)->get();

            if ($agents->first()) {
                if (!Auth::guard('agent')->check()) {
                    Auth::guard('agent')->loginUsingId($agents->first()->id, true);
                }

                $loggedAvatar = Auth::guard('agent')->user()->avatar;
                $loggedAgent = Auth::guard('agent')->user()->display_name;
            }
        }

        $view->with(['logged_in_user' => access()->user(),
            'agents'          => $agents,
            'logged_agent'    => $loggedAgent,
            'logged_avatar'   => $loggedAvatar]);
    }
}
