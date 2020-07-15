<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Category;

class AboutUsController extends Controller
{
    public function aboutUs()
	{
		$topMembers = User::where('admin',0)->orderBy('reputation_score', 'desc')->take(10)->get();

		$categories = Category::all();

		return view('about_us',compact('topMembers', 'categories'));
	}
}
