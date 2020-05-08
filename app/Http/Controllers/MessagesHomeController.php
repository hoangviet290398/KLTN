<?php

namespace App\Http\Controllers;
use App\Question;
use App\Answer;
use App\User;
use App\Message;
use App\User_Question_Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notification;
use Pusher\Pusher;
class MessagesHomeController extends Controller
{
	public function index()
	{
		//$messages=Message::all();
		$user = Auth::user();
		$users = User::where('_id','!=',$user->id)->get();

		// count how many message are unread from the selected user
		// $users = DB::select("select users._id, users.fullname, users.avatar, users.email, count(is_read) as unread 
		// from users LEFT  JOIN  messages ON users._id = messages.from_user and is_read = 0 and messages.to_user = " . $user->id . "
		// where users._id != " . $user->id . " 
		// group by users._id, users.fullname, users.avatar, users.email");
		$messages=Message::all();
		return view('messages.messages',compact('users','messages'));
	}
 
	public function getMessage($user_id)
	{
		$user=Auth::user();
		$my_id=$user->id;
		$messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from_user', $user_id)->where('to_user', $my_id);
        })->oRwhere(function ($query) use ($user_id, $my_id) {
            $query->where('from_user', $my_id)->where('to_user', $user_id);
		})->get();
		
		return view('messages.chatbox',compact('messages'));
	}

	public function sendMessage(Request $request)
    {
		$user=Auth::user();
        $from_user = $user->id;
        $to_user = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from_user = $from_user;
        $data->to_user = $to_user;
        $data->message = $message;
        $data->is_read = 0; // message will be unread when sending message
        $data->save();

        // pusher
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from_user' => $from_user, 'to_user' => $to_user]; // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);
    }
}