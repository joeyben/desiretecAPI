<?php

namespace App\Http\Controllers\Frontend\Messages;

use App\Http\Controllers\Controller;
use App\Mail\MessageSent;
use App\Models\Access\User\User;
use App\Models\Agents\Agent;
use App\Models\Messages\Message;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mail;

class MessagesController extends Controller
{
    public function index($wish_id)
    {
        $id = Auth::id();

        $messages = Message::where('user_id', '=', $id)
                    ->where('wish_id', '=', $wish_id)
                    ->get();

        $userName = User::where('id', '=', $id)->first()->first_name;

        $response = [
            'data'      => $messages,
            'user_name' => $userName
        ];

        return response()->json($response);
    }

    public function sendMessage(Request $request)
    {
        $consumerId = $request->user_id;
        $groupId = $request->group_id;
        $message = $request->input('message');
        $id = Auth::id();

        $sellersId = User::join('group_user', 'users.id', '=', 'group_user.user_id')
                    ->join('groups', 'group_user.group_id', '=', 'groups.id')
                    ->where('group_user.group_id', '=', $groupId)
                    ->pluck('user_id');

        if (\in_array($id, $sellersId->all(), true)) {
            $consumer = User::where('id', '=', $consumerId)->pluck('email');
            Mail::to($consumer)->send(new MessageSent($message));

            $message = Message::create([
                'user_id' => $consumerId,
                'wish_id' => $request->wish_id,
                'message' => $message
            ]);
        } else {
            $sellers = User::join('group_user', 'users.id', '=', 'group_user.user_id')
                            ->join('groups', 'group_user.group_id', '=', 'groups.id')
                            ->where('group_user.group_id', '=', $groupId)
                            ->pluck('email');

            foreach ($sellers as $seller) {
                Mail::to($seller)->send(new MessageSent($message));
            }

            $agent = Agent::where('user_id', $id)->where('status', 'Active')->value('id');

            $message = Message::create([
                'user_id' => $consumerId,
                'wish_id' => $request->wish_id,
                'message' => $message,
                'agent_id'=> $agent
            ]);
        }

        return ['status' => 'Message Sent!'];
    }

    public function getMessages($wish, $group)
    {
        $sellers = User::join('group_user', 'users.id', '=', 'group_user.user_id')
                        ->join('groups', 'group_user.group_id', '=', 'groups.id')
                        ->where('group_user.group_id', '=', $group)
                        ->pluck('user_id');

        $ids = $sellers->toArray();

        $agents = Agent::whereIn('user_id', $ids)->pluck('id');
        $agentsId = $agents->toArray();

        $id = Auth::id();

        if (\in_array($id, $ids, true)) {
            $user = Agent::where('user_id', '=', $id)
                            ->where('status', 'Active')
                            ->value('display_name');
        } else {
            $user = User::where('id', '=', $id)->first()->first_name;
        }

        $userMessages = User::join('message', 'users.id', '=', 'message.user_id')
                        ->whereNotIn('user_id', $ids)
                        ->where('wish_id', '=', $wish)
                        ->get();

        $agentMessages = Agent::join('message', 'agents.id', '=', 'message.agent_id')
                                ->whereIn('agent_id', $agentsId)
                                ->where('wish_id', '=', $wish)
                                ->get();

        $path = Storage::disk('s3')->url('img/agent/');
        foreach ($agentMessages as $agentMessage) {
            $agentMessage['avatar'] = $path . $agentMessage['avatar'];
        }

        $messages = array_merge($userMessages->toArray(), $agentMessages->toArray());

        $response = [
            'data'   => $messages,
            'user'   => $user,
        ];

        return response()->json($response);
    }

    public function deleteMessage($id)
    {
        Message::find($id)->delete();
    }

    public function editMessage($id, $message)
    {
        $m = Message::find($id);

        $m->message = $message;

        $m->save();
    }
}
