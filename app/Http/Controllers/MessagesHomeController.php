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

		// count how many message are unread from the selected user
		// $users = DB::select("select users._id, users.fullname, users.avatar, users.email, count(is_read) as unread 
		// from users LEFT  JOIN  messages ON users._id = messages.from_user and is_read = 0 and messages.to_user = " . $user->id . "
		// where users._id != " . $user->id . " 
        // group by users._id, users.fullname, users.avatar, users.email");
        
        if(Auth::check())
        {
            $users = User::where('_id','!=',$user->id)->get();
            $messages=Message::all();
            $userProfile=User::where('_id','=',$user->id)->get();
            
            
            $my_id=$user->id;
            
            
            foreach($users as $receiver) {
                $receiver_id=$receiver->_id;
                $latestMessage = Message::where(function ($query) use ($receiver_id, $my_id) {
                $query->where('from_user', $receiver_id)->where('to_user', $my_id);
                })->oRwhere(function ($query) use ($receiver_id, $my_id) {
                $query->where('from_user', $my_id)->where('to_user', $receiver_id);
                })->orderBy('created_at', 'desc')->get()->take(1);      
            
                $json_merge[]=array(json_decode($latestMessage,true));
            }

            $latestUserMessages=$json_merge;
                
            
		    return view('messages.messages',compact('users','messages','userProfile','latestUserMessages'));
        }
        else
        {
            return view('log.signin');
        }
		
	}
    
	public function getMessage($user_id)
	{
		$user=Auth::user();
        $my_id=$user->id;
        
        //update message has been read
        Message::where(['from_user'=>$user_id,'to_user'=>$my_id])->update(['is_read'=>1]);    
        //
		$messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from_user', $user_id)->where('to_user', $my_id);
        })->oRwhere(function ($query) use ($user_id, $my_id) {
            $query->where('from_user', $my_id)->where('to_user', $user_id);
        })->get();
        
        
        
		return view('messages.chatbox',compact('messages'));
	}

    public function getProfile($user_id)
    {
        $userProfile=User::where('_id','=',$user_id)->get();
		return view('messages.user_profile',compact('userProfile'));
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

        $data = ['from_user' => $from_user, 'to_user' => $to_user,'message'=>$message]; // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);
    }

    public function ajaxSearchUserForChat(Request $request){
        $user_name = $request->user_name;
        $users = User::whereRaw(array('$text'=>array('$search'=> $user_name)))->get();
        if($users->count()<=0) return "";

        $user_auth = Auth::user();

		// count how many message are unread from the selected user
		// $users = DB::select("select users._id, users.fullname, users.avatar, users.email, count(is_read) as unread 
		// from users LEFT  JOIN  messages ON users._id = messages.from_user and is_read = 0 and messages.to_user = " . $user->id . "
		// where users._id != " . $user->id . " 
        // group by users._id, users.fullname, users.avatar, users.email");
        
        if(Auth::check())
        {
            $users = User::whereRaw(array('$text'=>array('$search'=> $user_name)))->where('_id','!=',$user_auth->id)->get();
            // $messages=Message::all();
            // $userProfile=User::where('_id','=',$user_auth->id)->get();
            
            
            $my_id=$user_auth->id;
            
            
            foreach($users as $receiver) {
                $receiver_id=$receiver->_id;
                $latestMessage = Message::where(function ($query) use ($receiver_id, $my_id) {
                $query->where('from_user', $receiver_id)->where('to_user', $my_id);
                })->oRwhere(function ($query) use ($receiver_id, $my_id) {
                $query->where('from_user', $my_id)->where('to_user', $receiver_id);
                })->orderBy('created_at', 'desc')->get()->take(1);      
            
                $json_merge[]=array(json_decode($latestMessage,true));
            }

            $latestUserMessages=$json_merge;

        foreach($users as $user){
            echo view('layout.search_user_message',compact('user', 'latestUserMessages'));
            }
        }
    }

    public function ajaxSearchUserForChat1(Request $request){
        $user_name = $request->user_name;
        $users = User::all();
        if($users->count()<=0) return "";

        $user_auth = Auth::user();

		// count how many message are unread from the selected user
		// $users = DB::select("select users._id, users.fullname, users.avatar, users.email, count(is_read) as unread 
		// from users LEFT  JOIN  messages ON users._id = messages.from_user and is_read = 0 and messages.to_user = " . $user->id . "
		// where users._id != " . $user->id . " 
        // group by users._id, users.fullname, users.avatar, users.email");
        
        if(Auth::check())
        {
            $users = User::where('_id','!=',$user_auth->id)->get();
            // $messages=Message::all();
            // $userProfile=User::where('_id','=',$user_auth->id)->get();
            
            
            $my_id=$user_auth->id;
            
            
            foreach($users as $receiver) {
                $receiver_id=$receiver->_id;
                $latestMessage = Message::where(function ($query) use ($receiver_id, $my_id) {
                $query->where('from_user', $receiver_id)->where('to_user', $my_id);
                })->oRwhere(function ($query) use ($receiver_id, $my_id) {
                $query->where('from_user', $my_id)->where('to_user', $receiver_id);
                })->orderBy('created_at', 'desc')->get()->take(1);      
            
                $json_merge[]=array(json_decode($latestMessage,true));
            }

            $latestUserMessages=$json_merge;

        foreach($users as $user){
            echo view('layout.search_user_message',compact('user', 'latestUserMessages'));
            }
        }
    }
}