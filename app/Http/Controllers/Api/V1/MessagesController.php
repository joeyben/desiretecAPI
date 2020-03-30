<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Contracts\MessagesControllerInterface;
use App\Models\Access\User\User;
use App\Models\Agents\Agent;
use App\Models\Messages\Message;
use App\Repositories\Frontend\Wishes\WishesRepository;
use App\Services\Flag\Src\Flag;
use Auth;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Storage;

class MessagesController extends APIController implements MessagesControllerInterface
{
    private $session;
    private $wishesRepository;
    private $auth;

    public function __construct(Store $session, WishesRepository $wishesRepository, AuthManager $authManager)
    {
        $this->session = $session;
        $this->wishesRepository = $wishesRepository;
        $this->auth = $authManager;
    }

    public function list(int $wishId, int $groupId)
    {
        $sellersIds = User::join('group_user', 'users.id', '=', 'group_user.user_id')
                        ->join('groups', 'group_user.group_id', '=', 'groups.id')
                        ->where('group_user.group_id', '=', $groupId)
                        ->pluck('user_id')
                        ->toArray();

        $agentsIds = Agent::whereIn('user_id', $sellersIds)->pluck('id')->toArray();

        $loggedUserId = Auth::guard('api')->user()->id;
        if (\in_array($loggedUserId, $sellersIds, true)) {
            $userName = Agent::where('user_id', '=', $loggedUserId)
                            ->where('status', 'Active')
                            ->value('display_name');
        } else {
            $userName = User::where('id', '=', $loggedUserId)->first()->first_name;
        }

        $userMessages = User::join('message', 'users.id', '=', 'message.user_id')
                        ->whereNotIn('user_id', $sellersIds)
                        ->where('wish_id', '=', $wishId)
                        ->get();

        $agentMessages = Agent::join('message', 'agents.id', '=', 'message.agent_id')
                                ->whereIn('agent_id', $agentsIds)
                                ->where('wish_id', '=', $wishId)
                                ->get();

        foreach ($agentMessages as $agentMessage) {
            $path = Storage::disk('s3')->url('img/agent/');
            $agentMessage['avatar'] = $path . $agentMessage['avatar'];
        }

        $messages = array_merge($userMessages->toArray(), $agentMessages->toArray());
        array_multisort(array_column($messages, 'created_at'), SORT_ASC, $messages);

        $response = [
            'data'   => $messages,
            'user'   => $userName,
        ];

        return response()->json($response);
    }

    public function create(Request $request)
    {
        try {
            $consumerId = $request->user_id;
            $message = $request->input('message');
            $agentId = null;

            if ($this->auth->user()->hasRole(Flag::SELLER_ROLE) && Auth::guard('agent')->check()) {
                $agentId = Auth::guard('agent')->user()->id;
                $wish = $this->wishesRepository->getWish($request->wish_id);

                $this->wishesRepository->update($wish, ['agent_id' => $agentId]);
            }

            $m = Message::create([
                'user_id' => $consumerId,
                'wish_id' => $request->wish_id,
                'message' => $message,
                'agent_id'=> $agentId
            ]);

            return  $this->respondCreated('message: ' . $m->message);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->respondWithError($e->errorInfo);
        }
    }

    public function delete(int $id)
    {
        Message::findOrFail($id)->delete();

        return $this->respondUpdated('message deleted successfully');
    }

    public function update(int $id, Request $request)
    {
        try {
            $m = Message::findOrFail($id);

            $m->message = $request->input('message');

            if ($m->save()) {
                return $this->respondUpdated('message updated successfully');
            }
            throw new GeneralException(trans('exceptions.backend.wishes.update_error'));
        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }
}
