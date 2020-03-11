<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;


class SignInController extends Controller
{

    public function view()
    {    
        return view('log.signin');
    }

    public function postSignIn(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if(!Auth::attempt(['email'=>$email, 'password'=>$password]))
        {
            return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['approve' => 'The email or password is incorrect.',]);
        }
        else
        {
            $user = User::where('email',$email)->get()->first();
            if($user->admin == 1)
            {
                return redirect()->route('adminHomePage'); 
            }else{
                return redirect()->route('homePage'); 
            }          
        }
    }

    public function logout()
    {
        Auth::logout();
        Session()->flush();
        
        return redirect()->route('homePage');
    }
}