<?php

namespace App\Http\Controllers\Frontend\Messages;

use Auth;
use Mail;
use App\Mail\MessageSent;
use App\Models\Access\User\User;
use App\Models\Messages\Message;
use App\Models\Groups\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    public function index($wish_id)
    {
        // $chats = Chat::where(function ($query) use ($id) {
        //     $query->where('user_id', '=', Auth::user()->id)->where('friend_id', '=', $id);
        //     })->orWhere(function ($query) use ($id) {
        //     $query->where('user_id', '=', $id)->where('friend_id', '=', Auth::user()->id);
        //     })->get();

        $id = Auth::id();

        

        $messages = Message::where('user_id', '=', $id)
                    ->where('wish_id', '=', $wish_id)
                    ->get();

        $user_name = User::where('id', '=', $id)->first()->first_name;

        $response = [
            'data' => $messages,
            'user_name' => $user_name
        ];
        
        return response()->json($response);
       
    }

    public function sendMessage(Request $request)
    {
        $consumer_id = $request->user_id;
        $group_id = $request->group_id;
        $message = $request->input('message');

        $s = User::join('group_user', 'users.id', '=', 'group_user.user_id')
                    ->join('groups', 'group_user.group_id', '=', 'groups.id')
                    ->where('group_user.group_id', '=', 1)
                    ->pluck('user_id');        

        if(in_array(Auth::id(), $s->all()))
        {
            
            $consumer = User::where('id', '=', $consumer_id)->pluck('email');
            Mail::to($consumer)->send(new MessageSent($message));
        }
        else
        {
            $sellers = User::join('group_user', 'users.id', '=', 'group_user.user_id')
                            ->join('groups', 'group_user.group_id', '=', 'groups.id')
                            ->where('group_user.group_id', '=', $group_id)
                            ->pluck('email');

            foreach($sellers as $seller){
                Mail::to($seller)->send(new MessageSent($message));
            }
            
        }

        $message = Message::create([
            'user_id' => $consumer_id,
            'wish_id' => $request->wish_id,
            'message' => $message
        ]);
        
        return ['status' => 'Message Sent!'];

    }

    public function getMessages($wish, $group) 
    {
        $id = Auth::id();

        $sellers = User::join('group_user', 'users.id', '=', 'group_user.user_id')
                        ->join('groups', 'group_user.group_id', '=', 'groups.id')
                        ->where('group_user.group_id', '=', $group)
                        ->pluck('user_id');
          
        $ids = $sellers->toArray();                
        if(in_array(Auth::id(), $ids))
        {
            $ids = User::join('message', 'users.id', '=', 'message.user_id')
                        ->where('message.wish_id', '=', $wish)
                        ->pluck('user_id')->toArray();

        }
        else
        {
            array_push($ids, $id); 
        }

        $messages = User::join('message', 'users.id', '=', 'message.user_id')
                        ->whereIn('user_id', $ids)
                        ->where('wish_id', '=', $wish)
                        ->get();

        $user = User::where('id', '=', $id)->first()->first_name;

        $response = [
            'data' => $messages,
            'user' => $user
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
