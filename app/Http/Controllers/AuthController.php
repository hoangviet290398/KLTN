<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    /**
     * Redirect the user to the Github authentication page
     *
     * @return Response
     */
    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Github
     *
     * @return Response
     */
    public function handleProviderCallback($provider) 
    {
        // Get github's user infomation
        $user = Socialite::driver($provider)->user();

        // Tạo user với các thông tin lấy được từ github
        $is_existed_user = User::where('email', $user->getEmail())->where('provider_id',$user->getId());
		if($is_existed_user->count()==0)
		{
	        $createdUser = User::firstOrCreate([
	            'provider' => $provider,
	            'fullname' => $user->getName(),
	            'email' => $user->getEmail(),
	            'avatar' => $user->getAvatar(),
	            'provider_id' => $user->getId(),
	            'admin' => 0,
	            'token' => $user->token,

	        ]);
	        Auth::login($createdUser);
		}else{
			 $createdUser = User::firstOrCreate([
	            'provider' => $provider,
	            'fullname' => $user->getName(),
	            'email' => $user->getEmail(),
	            'avatar' => $user->getAvatar(),
	            'provider_id' => $user->getId(),
	            'admin' => 0
	           
	        ]);
			Auth::login($createdUser);
		}
        
        // Login với user vừa tạo.
        
        return redirect('/');
    }
}
