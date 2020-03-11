<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Answer;
use App\User;
use File;
use Illuminate\Support\Facades\Hash;
use App\Notification;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\InformationRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function indexManageQuestion()
	{
        $limit = \Config::get('constants.options.ItemNumberPerPage');
        $questions = Auth::user()->questions()->paginate($limit);
		$active_manage_question = true;

		return view('profile.manage_question',compact('questions','active_manage_question'));
	}

	public function indexManageAnswer()
	{
        $limit = \Config::get('constants.options.ItemNumberPerPage');
        $answers = Auth::user()->answers()->paginate($limit);
		$active_manage_answer = 'active';

		return view('profile.manage_answer',compact('answers','active_manage_answer'));
	}

	public function changeAvatar(Request $request)
	{
		if ($request->hasFile('avatar')) {
            $user = Auth::user();

            $filename = $user->_id.'.'.$request->avatar->getClientOriginalExtension();
            $typeAvatar = $request->avatar->getMimeType();

            if( $typeAvatar == 'image/png' || 
                $typeAvatar == 'image/jpg' || 
                $typeAvatar == 'image/jpeg') {

                if($user->avatar!='default_avatar.png') Storage::delete('public/avatars/'.$user->avatar);
                    $request->avatar->storeAs('public/avatars/', $filename);
                    $user->avatar=$filename;
                    $user->save();
                    Auth::user()->avatar = $filename;
            } else {
                session()->flash('errorsAvatar','Images only support JPG, PNG, and JPEG formats');
            }
        }

        return back()->withInput();
    }
    
    public function removeNotification($id)
    {
        $notification = Notification::find($id);
        if(Auth::user()->_id==$notification->user_id) 
            $notification->delete();

        return redirect()->back();
    }

    public function readNotification()
    {
        foreach(Auth::user()->notifications as $notification){
            if(!$notification->is_read){
                $notification->is_read = true;
                $notification->save();
            }
        }
    }

    public function createNotification($user, $target, $action, $question_id)
    {
        $notification = new Notification();
        $notification->user()->associate($user);
        $notification->actor()->associate(Auth::user());
        $notification->target = $target;
        $notification->action = $action;
        $notification->is_read = false;
        $notification->question_id = $question_id;
        $notification->save();

        $user->save();
    }

    public function removeQuestion(Request $request)
	{
        (new QuestionController)->removeQuestion($request);

		return redirect()->route('manageQuestion');
	}

    public function indexInformation () {
        $user = Auth::user();
        $active_personal_info = true;
        
        return view('profile.information',compact('user','active_personal_info'));
    }

    public function updateInformation (InformationRequest $request) {
        $user = Auth::user();
        $user->fullname = $request->fullname;
        $user->about_me = $request->aboutme;
        $user->save();
        Session()->flash('message', 'Complete!');

        return redirect()->back();
    }

    public function indexChangePassword () {
        $user = Auth::user();
        $active_change_pass = true;

        return view('profile.change_password',compact('user','active_change_pass'));
    }

    public function storeChangePassword(ChangePasswordRequest $request) {
        $user = Auth::user();
        $curentpassword = $user->password;
        if (!Hash::check($request->curentpassword, $curentpassword)) {
            Session()->flash('error', 'Current password is not correct!');
            
            return redirect()->back();       
        } 
        else {
            $user->password = bcrypt($request->newpassword);
            $user->save();
            Session()->flash('message', 'Change password complete!');

            return redirect()->back();
        }  
    }
    
    public function personalInfomation($id)
	{
        $user = User::find($id);
        if(empty($user)) return back();

		$questions = $user->questions;
		$answers = $user->answers;
		$totalLike = $questions->sum('total_like')+$answers->sum('total_like');
		$totalDislike = $questions->sum('total_dislike')+$answers->sum('total_dislike');
        $totalAccepted = 0;
		foreach($answers as $answer){
			$totalAccepted+=$answer->question->where('best_answer_id',$answer->_id)->count();
		}

		return view('profile.personal_infomation',compact('user','totalLike','totalDislike','totalAccepted'));
	}

  
    
}
