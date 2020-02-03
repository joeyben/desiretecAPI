<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Contracts\MessagesControllerInterface;
use App\Models\Messages\Message;
use App\Models\Access\User\User;
use App\Models\Agents\Agent;
use App\Repositories\Frontend\Wishes\WishesRepository;
use App\Events\Frontend\Messages\MessageCreated;
use App\Services\Flag\Src\Flag;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;

class MessagesController extends APIController implements MessagesControllerInterface
{
    private $session;
    private $wishesRepository;

    public function __construct(Store $session, WishesRepository $wishesRepository)
    {
        $this->session = $session;
        $this->wishes = $wishesRepository;
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

        $path = Storage::disk('s3')->url('img/agent/');
        foreach ($agentMessages as $agentMessage) {
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
        $consumerId = $request->user_id;
        $message = $request->input('message');
        $agentId = null;

        // TODO: Resolve current agent
        // if ($this->auth->guard('agent')->check() && $this->auth->guard('web')->user()->hasRole(Flag::SELLER_ROLE)) {
        if (true) {

            // TODO: Get current agent
            $agentId = 155;
            // $agentId = $this->auth->guard('agent')->user()->id;

            $wish = $this->wishes->find($request->wish_id);
            $this->wishes->update($wish, ['agent_id' => $agentId]);
        }

        try {
            $message = Message::create([
                'user_id' => $consumerId,
                'wish_id' => $request->wish_id,
                'message' => $message,
                'agent_id'=> $agentId
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->respondWithError($e->errorInfo);
        }

        // TODO: Check why MessageCreated returns error route not found
        // if ($message) {
        //     event(new MessageCreated($message));
        // }

        return  $this->respondCreated('message: ' . $message);
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

            if($m->save()) {
                return $this->respondUpdated('message deleted successfully');
            } else {
                throw new GeneralException(trans('exceptions.backend.wishes.update_error'));
            }

        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }
}
