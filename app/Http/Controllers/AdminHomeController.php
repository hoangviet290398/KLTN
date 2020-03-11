<?php

namespace App\Http\Controllers;
use App\Question;
use App\Answer;
use App\User;
use App\User_Question_Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notification;

class AdminHomeController extends Controller
{
	public function index()
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
        $users = User::orderBy('created_at', 'desc')->paginate($limit);
        $users->setPath('/');
        $questions = Question::orderBy('created_at', 'desc')->paginate($limit);
        $questions->setPath('/');
		return view('admin.adminhome_users',compact('users','questions'));
	}

	public function manageUsers(){
		$limit=20;
        $users = User::orderBy('created_at', 'desc')->paginate($limit);
        $users->setPath('/');

		return view('admin.adminhome_users',compact('users'));
	}

	public function manageQuestions()
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
        $questions = Question::orderBy('created_at', 'desc')->paginate($limit);
        $questions->setPath('/');
      
     	return view('admin.adminhome_questions',compact('questions'));
	}

	public function destroy(Request $request)
	{
		$this->removeQuestion($request);


		
		return redirect()->back();
	}


	public function removeQuestion(Request $request)
	{
		$question = Question::find($request->_id);

		if(empty($question)) return 'Question not found';

		$question->delete();

		(new UserController)->createNotification($question->user, Notification::$target['question'], Notification::$action['deleted'],  $question->_id);
	}

	public function destroyanswer(Request $request)
	{
		$this->removeAnswer($request);

		
		return redirect()->back();
	}

	public function removeAnswer(Request $request)
	{
		$answer = Answer::find($request->_id);

		if(empty($answer)) return 'Answer not found';

		$answer->delete();

		(new UserController)->createNotification($answer->user, Notification::$target['answer'], Notification::$action['deleted'],  $answer->question->_id);
	}

	public function destroyuser(Request $request)
	{
		$this->removeUser($request);

		
		return redirect()->back();
	}

	public function removeUser(Request $request)
	{
		$user = User::find($request->_id);
		$question = Question::where('user_id',$request->_id);
		$answer = Answer::where('user_id',$request->_id);

		if(empty($user)) return 'User not found';
		$answer->delete();
		$question->delete();

		$user->delete();	

		
	}

	public function manageQuestionsByUser($id)
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
		$questions = Question::where('user_id',$id)->orderBy('created_at', 'desc')->paginate($limit);
		$questions->setPath('/');

		$created_by = User::where('_id',$id)->first();

		return view('admin.adminhomequestionsbyuser',compact('questions','created_by')); 
	}

	public function manageAnswersByUser($id)
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
		$answers = Answer::where('user_id',$id)->orderBy('created_at', 'desc')->paginate($limit);
		$answers->setPath('/');

		$created_by = User::where('_id',$id)->first();

		return view('admin.adminhomeanswersbyuser',compact('answers','created_by')); 
	}

	public function adminAjaxAllUsers(Request $request)
	{
		$limit = 20;
		$keyword = $request->keyword;

		$users = User::whereRaw(array('$text'=>array('$search'=> $keyword)))->where('admin',0)->orderBy('created_at', 'desc')->paginate($limit);
		$users->setPath('/');

		if($users->count()<=0) return "";
		foreach($users as $user){
			echo view('admin.admin_search_user',compact('user'));
		}
	}

	public function adminAjaxAllUsers1(Request $request)
	{
		$limit = 20;
		
		$users = User::where('admin',0)->orderBy('created_at', 'desc')->paginate($limit);
		$users->setPath('/');
		// if($users->count()<=0) return "";
		foreach($users as $user){
			echo view('admin.admin_search_user',compact('user'));
		}
	}

	public function logout()
    {
        Auth::logout();
        Session()->flush();
        
        return redirect()->route('adminHomePage');
    }

}