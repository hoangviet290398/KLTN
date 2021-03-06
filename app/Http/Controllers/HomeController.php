<?php

namespace App\Http\Controllers;
use App\Question;
use App\User;
use App\Category;
use App\Answer;
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

		$topMembers = User::where('admin',0)->orderBy('reputation_score', 'desc')->take(10)->get();

		$categories = Category::all();

		
		
		return view('home',compact('questions','topMembers', 'categories'));
	}

	public function mostAnswered()
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
		$questions = Question::orderBy('total_answer', 'desc')->paginate($limit);
		$questions->setPath('/');

		$topMembers = User::where('admin',0)->orderBy('reputation_score', 'desc')->take(10)->get();
		$categories = Category::all();
		
		return view('home_most_answered',compact('questions','topMembers','categories'));
	}

	public function noAnswers()
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
		$questions = Question::where('total_answer', 0)->orderBy('created_at', 'desc')->paginate($limit);
		$questions->setPath('/');

		$topMembers = User::where('admin',0)->orderBy('reputation_score', 'desc')->take(10)->get();
		$categories = Category::all();
		
		return view('home_no_answers',compact('questions','topMembers','categories'));
	}

	public function week()
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
	
		$questions = Question::where('created_at','>=', Carbon::now()->startOfWeek())->orderBy('created_at', 'desc')->paginate($limit);
	

		$topMembers = User::where('admin',0)->orderBy('reputation_score', 'desc')->take(10)->get();
		$categories = Category::all();
		
		return view('home_week',compact('questions','topMembers','categories'));
	}

	public function month()
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
	
		$questions = Question::where('created_at','>=', Carbon::now()->startOfMonth())->orderBy('created_at', 'desc')->paginate($limit);
	

		$topMembers = User::where('admin',0)->orderBy('reputation_score', 'desc')->take(10)->get();
		$categories = Category::all();
		
		return view('home_month',compact('questions','topMembers','categories'));
	}

	public function year()
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
	
		$questions = Question::where('created_at','>=', Carbon::now()->startOfYear())->orderBy('created_at', 'desc')->paginate($limit);
	

		$topMembers = User::where('admin',0)->orderBy('reputation_score', 'desc')->take(10)->get();
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
		$limit=\Config::get('constants.options.ItemNumberPerPage');
		$keyword = $request->keyword;
		$key_word_array = explode(' ', $keyword);
		$topMembers = User::where('admin',0)->orderBy('reputation_score', 'desc')->take(10)->get();

		$categories = Category::all();
		// var_dump($key_word_array);
		// die;
		$word = [];
		$syntax = [];
		$sample_syntax = ['tag:', 'user:', 'answers:', 'hasaccepted:', 'is:', 'views:'];
		foreach($key_word_array as $key => $value){
			foreach($sample_syntax as $sam){
				if(strpos($value, $sam) !== false){
					array_push($syntax, $value);
					//$syntax[$sam] = str_replace($sam, '', $value);
				}
			}
		}
		// var_dump($syntax);
		// die;
		$raw_keyword = implode(' ', array_diff($key_word_array, $syntax));
		// var_dump($raw_keyword);
		// die;
		// var_dump($syntax);	
		// die;
		//$category_id = Category::where('name','Python')->first()->_id;
		// var_dump($category_id);
		// die;
		$all_question = Question::whereRaw(array('$text'=>array('$search'=> $keyword)))->where('category_id', '5edde2b80d2728638833ae28')->get()->count();
		// $result = $all_question::where('category_id', $category_id)->get();
		// var_dump($all_question);
		// die;
		if($syntax){
			foreach($syntax as $key => $value){
				if(strpos($value, 'tag:') !== false){
					$value = str_replace('tag:','',$value);
					$tag = Category::where('name',$value)->first();
					if($tag){
						if($raw_keyword !== ''){
							$questions = Question::where('category_id', $tag->_id)->whereRaw(array('$text'=>array('$search'=> $raw_keyword)))->paginate($limit)->appends(request()->query());
						}else{
							$questions = Question::where('category_id', $tag->_id)->paginate($limit)->appends(request()->query());
							return view('question_tag',compact('questions','topMembers', 'categories','tag'));
						}
						
					}else{
						$questions = Question::whereRaw(array('$text'=>array('$search'=> $keyword)))->paginate($limit)->appends(request()->query());
					}
					
				}elseif(strpos($value, 'user:') !== false){
					$value = str_replace('user:','',$value);
					$user = ($value == 'me') ? (Auth::user()->_id) : (User::where('_id',$value)->first()->_id);
					if($user){
						if($raw_keyword !== ''){
							$questions = Question::where('user_id', $user)->whereRaw(array('$text'=>array('$search'=> $raw_keyword)))->paginate($limit)->appends(request()->query());
						}else{
							$questions = Question::where('user_id', $user)->paginate($limit)->appends(request()->query());
						}
						
					}else{
						$questions = Question::whereRaw(array('$text'=>array('$search'=> $keyword)))->paginate($limit)->appends(request()->query());
					}
				}elseif(strpos($value, 'answers:') !== false){
					$value = (int)(str_replace('answers:','',$value));
					
					if(is_numeric($value)){
						if($raw_keyword !== ''){
							$questions = Question::where('total_answer','>=', $value)->whereRaw(array('$text'=>array('$search'=> $raw_keyword)))->paginate($limit)->appends(request()->query());
						}else{
							$questions = Question::where('total_answer','>=', $value)->paginate($limit)->appends(request()->query());
						}
						
					}else{
						$questions = Question::whereRaw(array('$text'=>array('$search'=> $keyword)))->paginate($limit)->appends(request()->query());
					}
				}elseif(strpos($value, 'hasaccepted:') !== false){
					$value = str_replace('hasaccepted:','',$value);
					if($value){
						if($value == 'yes'){
							$search_condition = Question::where('best_answer_id', '<>', null);
						}elseif($value == 'no'){
							$search_condition = Question::where('best_answer_id', '=', null);
						}else{
							$search_condition = Question::where('best_answer_id', '<>', null)->orWhere('best_answer_id', '=', null);
						}
						if($raw_keyword !== ''){
							$questions = $search_condition->whereRaw(array('$text'=>array('$search'=> $raw_keyword)))->paginate($limit)->appends(request()->query());
						}else{
							$questions = $search_condition->paginate($limit)->appends(request()->query());
						}
						
					}else{
						$questions = Question::whereRaw(array('$text'=>array('$search'=> $keyword)))->paginate($limit)->appends(request()->query());
					}
				}elseif(strpos($value, 'is:') !== false){
					$value = str_replace('is:','',$value);
					
					if($value){
						if($raw_keyword !== ''){
							if($value == 'question'){
								$questions = Question::whereRaw(array('$text'=>array('$search'=> $raw_keyword)))->paginate($limit)->appends(request()->query());
							}elseif($value == 'answer'){
								$answers = Answer::whereRaw(array('$text'=>array('$search'=> $raw_keyword)))->get();
								$question_key = [];
								foreach($answers as $key => $value){
									array_push($question_key, $value->question_id);
								}
								$questions = Question::whereIn('_id', $question_key)->paginate($limit)->appends(request()->query());
							}else{
								$questions = Question::whereRaw(array('$text'=>array('$search'=> $raw_keyword)))->paginate($limit)->appends(request()->query());
							}	
						}else{
							if($value == 'question'){
								$questions = Question::whereRaw(array('$text'=>array('$search'=> $keyword)))->paginate($limit)->appends(request()->query());
							}elseif($value == 'answer'){
								$questions = Answer::whereRaw(array('$text'=>array('$search'=> $keyword)))->paginate($limit)->appends(request()->query());
							}else{
								$questions = Question::whereRaw(array('$text'=>array('$search'=> $keyword)))->paginate($limit)->appends(request()->query());
							}	
						}
						
					}else{
						$questions = Question::whereRaw(array('$text'=>array('$search'=> $keyword)))->paginate($limit)->appends(request()->query());
					}
				}elseif(strpos($value, 'views:') !== false){
					$value = (int)(str_replace('views:','',$value));
					
					if(is_numeric($value)){
						if($raw_keyword !== ''){
							$questions = Question::where('total_view','>=', $value)->whereRaw(array('$text'=>array('$search'=> $raw_keyword)))->paginate($limit)->appends(request()->query());
						}else{
							$questions = Question::where('total_view','>=', $value)->paginate($limit)->appends(request()->query());
						}
						
					}else{
						$questions = Question::whereRaw(array('$text'=>array('$search'=> $keyword)))->paginate($limit)->appends(request()->query());
					}
				}
			}
		}else{
			$answers = Answer::whereRaw(array('$text'=>array('$search'=> $raw_keyword)))->get();
			$question_key = [];
			foreach($answers as $key => $value){
				array_push($question_key, $value->question_id);
			}
			
			$questions = Question::whereRaw(array('$text'=>array('$search'=> $raw_keyword)))->orWhereIn('_id', $question_key)->paginate($limit)->appends(request()->query());
		}	
		return view('question.search_result',compact('questions','keyword','topMembers','categories','all_question'));
	}

	public function viewByCategory($id)
	{
		$limit=\Config::get('constants.options.ItemNumberPerPage');
		$questions = Question::where('category_id',$id)->orderBy('created_at', 'desc')->paginate($limit);
		$questions->setPath('/');

		$topMembers = User::where('admin',0)->orderBy('reputation_score', 'desc')->take(10)->get();

		$categories = Category::all();

		$tag = Category::where('_id',$id)->first();


		
		return view('question_tag',compact('questions','topMembers', 'categories','tag'));
	}

	public function allUsers()
	{
		$limit = 20;
		$users = User::where('admin',0)->orderBy('reputation_score', 'desc')->paginate($limit);
		$users->setPath('/');

		return view('user.all_users',compact('users'));
	}

	public function ajaxAllUsers(Request $request)
	{
		$limit = 20;
		$keyword = $request->keyword;
		
		$users = User::whereRaw(array('$text'=>array('$search'=> $keyword)))->where('admin',0)->orderBy('reputation_score', 'desc')->paginate($limit);
	
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