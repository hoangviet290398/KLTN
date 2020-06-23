<?php

namespace App\Http\Controllers;
use App\Question;
use App\User;
use App\Category;
use App\User_Question_Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Carbon\Carbon;


class HomeController extends Controller
{
	public function index()
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
		$questions = Question::orderBy('created_at', 'desc')->paginate($limit);
		$questions->setPath('/');

		$topMembers = User::all();

		$categories = Category::all();

		
		
		return view('home',compact('questions','topMembers', 'categories'));
	}

	public function mostAnswered()
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
		$questions = Question::orderBy('total_answer', 'desc')->paginate($limit);
		$questions->setPath('/');

		$topMembers = User::all();
		$categories = Category::all();
		
		return view('home_most_answered',compact('questions','topMembers','categories'));
	}

	public function noAnswers()
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
		$questions = Question::where('total_answer', 0)->orderBy('created_at', 'desc')->paginate($limit);
		$questions->setPath('/');

		$topMembers = User::all();
		$categories = Category::all();
		
		return view('home_no_answers',compact('questions','topMembers','categories'));
	}

	public function week()
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
	
		$questions = Question::where('created_at','>=', Carbon::now()->startOfWeek())->orderBy('created_at', 'desc')->paginate($limit);
	

		$topMembers = User::all();
		$categories = Category::all();
		
		return view('home_week',compact('questions','topMembers','categories'));
	}

	public function month()
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
	
		$questions = Question::where('created_at','>=', Carbon::now()->startOfMonth())->orderBy('created_at', 'desc')->paginate($limit);
	

		$topMembers = User::all();
		$categories = Category::all();
		
		return view('home_month',compact('questions','topMembers','categories'));
	}

	public function year()
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
	
		$questions = Question::where('created_at','>=', Carbon::now()->startOfYear())->orderBy('created_at', 'desc')->paginate($limit);
	

		$topMembers = User::all();
		$categories = Category::all();
		
		return view('home_year',compact('questions','topMembers','categories'));
	}

	public function ajaxSearch(Request $request){
		$questions = $this->runSearch($request->keyword);
		if($questions->count()<=0) return "";

		foreach($questions as $question){
			echo view('layout.search_link',compact('question'));
		}
	}

	public function searchIndex(Request $request){
		$keyword = $request->keyword;
		$limit=\Config::get('constants.options.ItemNumberPerPage');
		$all_question = Question::whereRaw(array('$text'=>array('$search'=> $keyword)))->get()->count();
		$questions = Question::whereRaw(array('$text'=>array('$search'=> $keyword)))->paginate($limit)->appends(request()->query());

		$topMembers = User::all();
		$categories = Category::all();
		
		return view('question.search_result',compact('questions','keyword','topMembers','categories','all_question'));
	}

	public function viewByCategory($id)
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
		$questions = Question::where('category_id',$id)->orderBy('created_at', 'desc')->paginate($limit);
		$questions->setPath('/');

		$topMembers = User::all();

		$categories = Category::all();

		$tag = Category::where('_id',$id)->first();


		
		return view('question_tag',compact('questions','topMembers', 'categories','tag'));
	}

	public function allUsers()
	{
		$limit = 20;
		$users = User::where('admin',0)->orderBy('created_at', 'desc')->paginate($limit);
		$users->setPath('/');

		return view('user.all_users',compact('users'));
	}

	public function ajaxAllUsers(Request $request)
	{
		$limit = 20;
		$keyword = $request->keyword;
		
		$users = User::whereRaw(array('$text'=>array('$search'=> $keyword)))->where('admin',0)->orderBy('created_at', 'desc')->paginate($limit);
	
		$users->setPath('/');
		
		if($users->count()<=0) return "";
		foreach($users as $user){
			echo view('layout.search_user',compact('user'));
		}

		//return view('user.all_users',compact('users'));
	}

	public function ajaxAllUsers1(Request $request)
	{
		$limit = 20;
		
		$users = User::where('admin',0)->orderBy('created_at', 'desc')->paginate($limit);
		$users->setPath('/');
		// if($users->count()<=0) return "";
		foreach($users as $user){
			echo view('layout.search_user',compact('user'));
		}

		//return view('user.all_users',compact('users'));
	}

	public function allTags()
	{
		$limit = 20;
		$categories = Category::orderBy('created_at', 'desc')->paginate($limit);
		$categories->setPath('/');

		return view('tags.all_tags',compact('categories'));
	}

	public function ajaxAllTags(Request $request)
	{
		$limit = 20;
		$keyword = $request->keyword;

		$categories = Category::whereRaw(array('$text'=>array('$search'=> $keyword)))->orderBy('created_at', 'desc')->paginate($limit);
		$categories->setPath('/');

		if($categories->count()<=0) return "";
		foreach($categories as $category){
			echo view('layout.search_category',compact('category'));
		}

		//return view('user.all_users',compact('users'));
	}

	public function ajaxAllTags1(Request $request)
	{
		$limit = 20;
		
		$categories = Category::orderBy('created_at', 'desc')->paginate($limit);
		$categories->setPath('/');
		// if($users->count()<=0) return "";
		foreach($categories as $category){
			echo view('layout.search_category',compact('category'));
		}

		//return view('user.all_users',compact('users'));
	}



	// public function runSearch($keyword){
		

	// 	return $fullText;
	// }
}