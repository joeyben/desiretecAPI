<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use App\Services\Flag\Src\Flag;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Str;
use Modules\Users\Notifications\ApiCreatedUserNotificationForExecutive;
use Modules\Users\Repositories\Contracts\UsersRepository;
use Modules\Whitelabels\Entities\LayerWhitelabel;
use Modules\Whitelabels\Entities\WhitelabelHost;
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
                [
                    'created_by'      => $user->id,
                    'name'            => $this->str->studly($request->get('name')),
                    'display_name'    => $request->get('name'),
                    'email'           => $request->get('email'),
                    'licence'         => (string) $request->get('licence'),
                    'domain'          => env('API_HTTP', 'https://') . str_slug($request->get('name')) . '.' . env('API_DOMAIN', 'reise-wunsch.com'),
                    'distribution_id' => 1,
                    'state'           => 1
                ]
            );

            $this->users->sync($user->id, 'whitelabels', [$result['whitelabel']->id]);
            $this->whitelabels->sync($result['whitelabel']->id, 'layers', [Flag::PACKAGE]);

            $host = WhitelabelHost::create([
                'host' => str_slug($request->get('name')) . '.' . env('API_DOMAIN', 'reise-wunsch.com'),
                'whitelabel_id'      =>$result['whitelabel']->id,
            ]);

            $layerWhitelabel = LayerWhitelabel::where('whitelabel_id', $result['whitelabel']->id)->where('layer_id', Flag::PACKAGE)->first();

            $layerWhitelabel->update([
                'headline' => 'Dürfen wir Sie beraten? ',
                'subheadline' => 'Unsere besten Reiseberater helfen ihnen gerne, Ihre persönliche Traumreise zu finden. Probieren Sie es einfach aus!',
                'headline_success' => 'Vielen Dank, Ihr Reisewunsch wurde versandt.',
                'subheadline_success' => 'Ein Berater aus dem Reisebüro nimmt sich Ihrer Wünsche an. Wenn Sie Ihren Reisewunsch noch einmal überprüfen wollen, ',
            ]);

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
