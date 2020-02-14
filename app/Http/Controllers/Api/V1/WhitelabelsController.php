<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Services\Flag\Src\Flag;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Str;
use Modules\Users\Notifications\ApiCreatedUserNotificationForExecutive;
use Modules\Users\Repositories\Contracts\UsersRepository;
use Modules\Whitelabels\Http\Requests\ApiStoreWhitelabelRequest;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class WhitelabelsController extends APIController
{
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $whitelabels;
    /**
     * @var \Illuminate\Support\Str
     */
    private $str;
    /**
     * @var \Modules\Users\Repositories\Contracts\UsersRepository
     */
    private $users;
    /**
     * @var \Illuminate\Notifications\ChannelManager
     */
    private $notification;

    public function __construct(WhitelabelsRepository $whitelabels, Str $str, UsersRepository $users, ChannelManager $notification)
    {
        $this->whitelabels = $whitelabels;
        $this->str = $str;
        $this->users = $users;
        $this->notification = $notification;
    }

    public function store(ApiStoreWhitelabelRequest $request)
    {
        try {
            $pool = '0123456789abcdefghijklmnopqrstuvwxyz';

            $password = mb_substr(str_shuffle(str_repeat($pool, 5)), 0, 6);

            $user = User::create([
                'first_name' => $request->get('name'),
                'email'      => $request->get('email'),
                'confirmed'  => true,
                'status'     => true,
                'password'   => bcrypt($password),
            ]);

            $user->attachRole(Role::where('name', Flag::EXECUTIVE_ROLE)->first());

            $user->storeToken();

            $result['whitelabel'] = $this->whitelabels->create(
                array_merge(
                    $request->only('email', 'licence'),
                    [
                        'created_by'      => $user->id,
                        'name'            => $this->str->studly($request->get('name')),
                        'display_name'    => $request->get('name'),
                        'domain'          => env('API_HTTP', 'https://') . str_slug($request->get('name')) . '.' . env('API_DOMAIN', 'reise-wunsch.com'),
                        'distribution_id' => 1,
                        'state'           => 1
                    ]
                )
            );

            $this->users->sync($user->id, 'whitelabels', [$result['whitelabel']->id]);

            $user->fresh();

            if ($user->hasRole(Flag::EXECUTIVE_ROLE)) {
                $this->notification->send($user, new ApiCreatedUserNotificationForExecutive($user, $password));
            }

            ini_set('max_execution_time', 500);
            $this->whitelabels->apiCopyLanguage($result['whitelabel']->id);

            return $this->responseJson($result);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }
}
