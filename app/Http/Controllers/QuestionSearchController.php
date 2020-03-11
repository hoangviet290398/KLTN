<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Question_Search;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddTopicRequest;
use Illuminate\Support\Facades\Storage;
class QuestionSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       
        $questions = Question_Search::all();
        var_dump($questions);
        exit;
        return view('QuestionSearch',compact('questions'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
        ]);

        $question = Question_Search::create($request->all());
        $question->addToIndex();

        return redirect()->back();
    }
}