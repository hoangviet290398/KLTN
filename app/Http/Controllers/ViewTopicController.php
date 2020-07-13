<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Answer;
use App\LikeDislike;
use App\Notification;
use App\User;
use App\Category;
use Session;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ViewTopicController extends Controller
{

    public function view($id)
    {
        $sessionKey = 'question_' . $id;
        $sessionView = Session::get($sessionKey);
        $post = Question::findOrFail($id);
        if (!$sessionView) { //nếu chưa có session
            Session::put($sessionKey, 1); //set giá trị cho session
            $post->increment('total_view');
        }

        $question = Question::find($id);
        if(empty($question)) return redirect()->back();

        $limit=\Config::get('constants.options.ItemNumberPerPage');
        $answers = Answer::where('question_id',$id)->orderBy('total_like','desc')->paginate($limit);
        $bestAnswer=null;
        $parsedown = new \Parsedown();
        $question->content = $parsedown->setMarkupEscaped(true)->text($question->content);
        $topMembers = User::all();
        
        foreach ($answers as $answer) 
        {
            $answer->content = $parsedown->text($answer->content);
        }
        if(!empty($question->bestAnswer)) 
        {
            $bestAnswer= $question->bestAnswer;
            $bestAnswer->content = $parsedown->setMarkupEscaped(true)->text($bestAnswer->content);
        }
        
        $categories = Category::all();

        return view('question.view_topic',compact('question','answers','bestAnswer','topMembers','categories'));
    
    }

    public function bestAnswer($id_answer)
    {
        
        $answer = Answer::find($id_answer);
        $question = $answer->question;
        if (Auth::user()->id==$question->user_id) 
        {
            $question->best_answer_id = $id_answer;
            $question->save();
            if(Auth::user()->id == $answer->user->id)
            {

            }else
            {
                $user = User::find($answer->user->id);
                $user->reputation_score += 30;
                $user->save();
                (new UserController)->createNotification($answer->user, Notification::$target['answer'], Notification::$action['accept'],  $question->_id);
            }
        }       

         return redirect()->back();      
    }

    public function removeBestAnswer($id_answer)
    {
       
        $question = Answer::find($id_answer)->question;
        $answer = Answer::find($id_answer);
        if (Auth::user()->id==$question->user_id)
        {            
            $question->best_answer_id = null;
            echo var_dump($question->best_answer_id);

            $question->save();

            $user = User::find($answer->user_id);
            $user->reputation_score -= 30;
            $user->save();
        }
        

        return redirect()->back(); 
    }
    
    public function checkLike($post_id,$post_type,$user_id)
    {
        $user_liked=LikeDislike::where('user_id',$user_id)->where('post_id', $post_id)->where('action', "Upvote")->where('post_type',$post_type)->first();

        return $user_liked;
    }

    public function checkDislike($post_id,$post_type,$user_id)
    {
        $user_disliked=LikeDislike::where('user_id',$user_id)->where('post_id', $post_id)->where('action', "Downvote")->where('post_type',$post_type)->first();

        return $user_disliked;
    }

    public function like(Request $request)
    {
        $post_id = $request->question_id;
        $post_type = $request->post_type;
        $vote = $request->vote;
        $user_liked    =$this->checkLike($post_id,$post_type,Auth::user()->id);
        $user_disliked =$this->checkDislike($post_id,$post_type,Auth::user()->id);
        
        if (!$user_liked){
            if ($post_type =='Question')
            {
                $question= Question::find($post_id);    
                $question->score = $vote;
                $question->save();
                if(Auth::user()->id == $question->user->id)
                {

                }else
                {
                    (new UserController)->createNotification($question->user, Notification::$target['question'], Notification::$action['upvote'],  $question->_id);
                }
            }
            else
            {
                $answer= Answer::find($post_id);       
                $answer->score = $vote;
                $answer->save();
                if(Auth::user()->id == $answer->user->id)
                {

                }else{
                    (new UserController)->createNotification($answer->user, Notification::$target['answer'], Notification::$action['upvote'],  $answer->question_id);   
                }         
            }            
            $this->addLikeDislike($post_id,$post_type,Auth::user(),"Upvote");            
            if ($user_disliked)
            {   

                if ($post_type =='Question')
                {         
                    $question->score = $vote;
                    $question->save();
                }
                else
                {            
                    $answer->score = $vote;
                    $answer->save();
                }
                $user_disliked->delete();
            }
        }
        else
        {
            if ($post_type =='Question')
            {
                $question= Question::find($post_id);    
                $question->score = $vote;
                $question->save();
            }
            else
            {   
                $answer= Answer::find($post_id);       
                $answer->score = $vote;
                $answer->save();
            }                
            $user_liked->delete();
        }

        $data['status'] = true;

        echo json_encode($data);  
    }

    public function dislike(Request $request)
    {
        $post_id = $request->question_id;
        $post_type = $request->post_type;
        $vote = $request->vote;
        $user_liked=$this->checkLike($post_id,$post_type,Auth::user()->id);
        $user_disliked=$this->checkDislike($post_id,$post_type,Auth::user()->id);
        if (!$user_disliked)
        {
            if ($post_type =='Question')
            {
                $question= Question::find($post_id);          
                $question->score = $vote;
                $question->save();
                if(Auth::user()->id == $question->user->id)
                {

                }else{
                    (new UserController)->createNotification($question->user, Notification::$target['question'], Notification::$action['downvote'],  $question->_id);
                }
            }
            else
            {
                $answer= Answer::find($post_id);              
                $answer->score = $vote;
                $answer->save();
                if(Auth::user()->id == $answer->user->id)
                {

                }else{
                    (new UserController)->createNotification($answer->user, Notification::$target['answer'], Notification::$action['downvote'],  $answer->question_id);
                }
            }
            $this->addLikeDislike($post_id,$post_type,Auth::user(),"Downvote"); 
            if ($user_liked)
            {   
                if ($post_type =='Question')
                {         
                    $question->score = $vote;
                    $question->save();
                }
                else
                {            
                    $answer->score = $vote;
                    $answer->save();
                }
                $user_liked->delete();
            }
        }
        else
        {
            if ($post_type =='Question')
            {
                $question= Question::find($post_id);          
                $question->score = $vote;
                $question->save();
            }
            else
            {
                $answer= Answer::find($post_id);            
                $answer->score = $vote;
                $answer->save();
            }

            $user_disliked->delete();
        }
       
        $data['status'] = true;

        echo json_encode($data);   
    }

    public function addLikeDislike($post_id,$post_type,$user,$action)
    {
        $likeDislike=new LikeDislike();
        $likeDislike->user()->associate($user);
        $likeDislike->post_id=$post_id;
        $likeDislike->post_type=$post_type;
        $likeDislike->action=$action;
        $likeDislike->save();
    }

}




