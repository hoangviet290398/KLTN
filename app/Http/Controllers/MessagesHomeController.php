<?php

namespace App\Http\Controllers;
use App\Question;
use App\Answer;
use App\User;
use App\User_Question_Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notification;

class MessagesHomeController extends Controller
{
	public function index()
	{
		
		return view('messages.messages');
	}

}