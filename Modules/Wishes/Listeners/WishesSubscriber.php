<?php

namespace Modules\Wishes\Listeners;

use App\Models\Access\Role\Role;
use App\Models\Access\User\Traits\TokenAuthenticable;
use App\Models\Access\User\User;
use App\Repositories\Frontend\Wishes\WishesRepository;
use App\Services\Flag\Src\Flag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Modules\Groups\Entities\Group;
use Modules\Wishes\Entities\Wish;
use Modules\Wishes\Notifications\AutoOfferNotification;
use Modules\Wishes\Notifications\CreatedWishNotification;
use Modules\Wishes\Notifications\CreatedWishNotificationForSeller;
use phpDocumentor\Reflection\Types\Boolean;

class WishesSubscriber
{
    /**
     * @var \Modules\Wishes\Entities\Wish
     */
    private $wish;

    private $wishRepo;

    /**
     * Create the event listener.
     */
    public function __construct(Wish $wish, WishesRepository $wishRepo)
    {
        $this->wish = $wish;
        $this->wishRepo = $wishRepo;
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('eloquent.created: Modules\Wishes\Entities\Wish', [$this, 'onCreatedWish']);
    }

    use TokenAuthenticable;

    public function onCreatedWish(Wish $wish, Boolean $fromApi)
    {
        $user = User::where('id', $wish->created_by)->firstOrFail();
        $wishTye = $this->wishRepo->manageRules($wish);

        $usertoken = $user->storeToken();

        $token = $usertoken->token->token;
        $wish['token'] = $token;
        $wish->load('owner');

        $users = Group::find($wish->group_id)->users()->get();
        //Notification::send($users, new CreatedWishNotificationForSeller($wish));
        //Auth::guard('web')->user()->notify((new AutoOfferNotification($wish))->delay(now()->addMinutes(10)));

        if ($wish->whitelabel->isAutooffer()) {
            //Auth::guard('web')->user()->notify((new AutoOfferNotification($wish)));
        }
        if (0 === $wishTye) {
            Notification::send($users, new CreatedWishNotificationForSeller($wish, $fromApi));
        }

        Auth::guard('web')->user()->notify(new CreatedWishNotification($wish, $fromApi));

        $admins = Role::where('name', Flag::ADMINISTRATOR_ROLE)->first()->users()->where('users.id', '!=', Auth::guard('web')->user()->id)->get();

        foreach ($admins as $admin) {
            $url = route('admin.wishes') . '#/edit/' . $wish->id;
            createNotification(Lang::get('notification.created', ['name' => 'Wish', 'url' => '<a  href="' . $url . '"> ' . $wish->title . '</a>', 'user' => Auth::guard('web')->user()->first_name . ' ' . Auth::guard('web')->user()->last_name]), $admin->id, Auth::guard('web')->user()->id);
        }
    }
}
