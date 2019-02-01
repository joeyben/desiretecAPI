<?php

namespace App\Http\Composers;

use App\Models\Agents\Agent;
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
        $id = Auth::id();
        $agents = Agent::where('user_id', 15)->get();

        $logged_avatar = Agent::where('user_id', 15)->where('status', 'Active')->value('avatar');
        $logged_agent = Agent::where('user_id', 15)->where('status', 'Active')->value('display_name');

        $view->with(['logged_in_user' => access()->user(),
                    'agents'          => $agents,
                    'logged_agent'    => $logged_agent,
                    'logged_avatar'   => $logged_avatar]);
    }
}
