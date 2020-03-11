<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use File;
use Validator;
use Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\SignUpRequests;

class SignUpController extends Controller
{
    public function index() {
        return view('log.signup');
	}
	
    public function store(SignUpRequests $request) {
		$user = new User();
		$user->fullname=$request->fullname;
		$user->email=$request->email;
		$user->password=bcrypt($request->password);
		$user->avatar = "default_avatar.png";
		$user->about_me = null;
		$user->admin = 0;
		$user->new_notification = 0;
		$user->save();		
		return redirect()->route('signInIndex');
	}
	
    public function validEmail(Request $request) {
		$user = User::where('email', $request->email);
		$result = $user->count()==0 ? true : false;

		return response()->json($result);
	}

}
