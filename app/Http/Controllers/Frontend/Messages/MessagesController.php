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

        $user_name = User::where('id', '=', $id)->first()->first_name;

        $response = [
            'data'      => $messages,
            'user_name' => $user_name
        ];

        return response()->json($response);
    }

    public function sendMessage(Request $request)
    {
        $consumer_id = $request->user_id;
        $group_id = $request->group_id;
        $message = $request->input('message');
        $id = Auth::id();

        $s = User::join('group_user', 'users.id', '=', 'group_user.user_id')
                    ->join('groups', 'group_user.group_id', '=', 'groups.id')
                    ->where('group_user.group_id', '=', 1)
                    ->pluck('user_id');

        if (\in_array($id, $s->all(), true)) {
            $consumer = User::where('id', '=', $consumer_id)->pluck('email');
            Mail::to($consumer)->send(new MessageSent($message));

            $message = Message::create([
                'user_id' => $consumer_id,
                'wish_id' => $request->wish_id,
                'message' => $message
            ]);
        } else {
            $sellers = User::join('group_user', 'users.id', '=', 'group_user.user_id')
                            ->join('groups', 'group_user.group_id', '=', 'groups.id')
                            ->where('group_user.group_id', '=', $group_id)
                            ->pluck('email');

            foreach ($sellers as $seller) {
                Mail::to($seller)->send(new MessageSent($message));
            }

            $agent = Agent::where('user_id', $id)->where('status', 'Active')->value('id');

            $message = Message::create([
                'user_id' => $consumer_id,
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
        $agents_id = $agents->toArray();

        $id = Auth::id();

        if (\in_array($id, $ids, true)) {
            $user = Agent::where('user_id', '=', $id)
                            ->where('status', 'Active')
                            ->value('display_name');
        } else {
            $user = User::where('id', '=', $id)->first()->first_name;
        }

        $user_messages = User::join('message', 'users.id', '=', 'message.user_id')
                        ->whereNotIn('user_id', $ids)
                        ->where('wish_id', '=', $wish)
                        ->get();

        $agent_messages = Agent::join('message', 'agents.id', '=', 'message.agent_id')
                                ->whereIn('agent_id', $agents_id)
                                ->where('wish_id', '=', $wish)
                                ->get();

        $path = Storage::disk('s3')->url('img/agent/');
        foreach ($agent_messages as $agent_message) {
            $agent_message['avatar'] = $path . $agent_message['avatar'];
        }

        $messages = array_merge($user_messages->toArray(), $agent_messages->toArray());

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
