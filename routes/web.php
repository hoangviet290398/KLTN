<?php
use App\Question_Search;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','HomeController@index')->name('homePage');
Route::get('mostanswered','HomeController@mostAnswered')->name('mostAnswered');
Route::get('noanswers','HomeController@noAnswers')->name('noAnswers');
Route::get('week','HomeController@week')->name('week');
Route::get('month','HomeController@month')->name('month');
Route::get('year','HomeController@year')->name('year');
Route::get('allusers','HomeController@allUsers')->name('allUsers');
Route::get('alltags','HomeController@allTags')->name('allTags');

Route::get('signup','SignUpController@index')->name('signUp');
Route::post('signup','SignUpController@store')->name('signUpStore');
Route::get('validEmail','SignUpController@validEmail')->name('validEmail');

//QuyTran add 1st May, 2020

//Messages system
Route::get('/messages', 'MessagesHomeController@index')->name('messages');
Route::get('/messages/{id}','MessagesHomeController@getMessage');
Route::post('/messages','MessagesHomeController@sendMessage');
Route::get('/getProfile/{id}','MessagesHomeController@getProfile');

//QuyTran end add

Route::get('signin',[
	'as' => 'signInIndex',
	'uses' => 'SignInController@view'
]);
Route::get('searchresult',[
	'as' => 'searchIndex',
	'uses' => 'HomeController@searchIndex'
]);

Route::get('ajaxsearch',[
	'as' => 'ajaxSearch',
	'uses' => 'HomeController@ajaxSearch'
]);

Route::get('ajaxsearchusers',[
	'as' => 'ajaxSearchUsers',
	'uses' => 'HomeController@ajaxAllUsers'
]);

Route::get('ajaxsearchusers1',[
	'as' => 'ajaxSearchUsers1',
	'uses' => 'HomeController@ajaxAllUsers1'
]);

Route::get('ajaxsearchtags',[
	'as' => 'ajaxSearchTags',
	'uses' => 'HomeController@ajaxAllTags'
]);

Route::get('ajaxsearchtags1',[
	'as' => 'ajaxSearchTags1',
	'uses' => 'HomeController@ajaxAllTags1'
]);
Route::get('QuestionSearch', 'QuestionSearchController@index');
Route::get('getquestion', 'HomeController@getQuestion');
Route::post('QuestionSearchCreate', 'QuestionSearchController@create');

Route::get('login/{provider}', 'AuthController@redirectToProvider');
Route::get('{provider}/callback', 'AuthController@handleProviderCallback');

Route::post('signin',[
	'as' => 'signIn',
	'uses' => 'SignInController@postSignIn'
]);


Route::get('topic/{id}',[
		'as' => 'viewTopic',
		'uses' => 'ViewTopicController@view'
]);

Route::get('category/{id}',[
		'as' => 'viewByCategory',
		'uses' => 'HomeController@viewByCategory'
]);

Route::get('aboutus',[
	'as' => 'aboutUs',
	'uses' => 'AboutUsController@aboutUs'
]);

Route::get('personalinfomation/{id}','UserController@personalInfomation')->name('personalInfomation');

/*Start middleware check admin*/
Route::middleware(['admin'])->group(function(){
	Route::get('admin','AdminHomeController@index')->name('adminHomePage');
	Route::get('manageusers','AdminHomeController@manageUsers')->name('manageAllUsers');
	Route::get('managequestions','AdminHomeController@manageQuestions')->name('manageAllQuestions');
	Route::post('admindeletetopic','AdminHomeController@destroy')->name('adminDeleteTopic');

	Route::post('admindeleteanswer','AdminHomeController@destroyanswer')->name('adminDeleteAnswer');

	Route::post('admindeleteuser','AdminHomeController@destroyuser')->name('adminDeleteUser');

	Route::get('questionsbyuser/{id}',[
		'as' => 'manageQuestionsByUser',
		'uses' => 'AdminHomeController@manageQuestionsByUser'
	]);

	Route::get('answersbyuser/{id}',[
		'as' => 'manageAnswersByUser',
		'uses' => 'AdminHomeController@manageAnswersByUser'
	]);

	Route::get('adminajaxsearchusers',[
	'as' => 'adminAjaxSearchUsers',
	'uses' => 'AdminHomeController@adminAjaxAllUsers'
	]);

	Route::get('adminajaxsearchusers1',[
		'as' => 'adminAjaxSearchUsers1',
		'uses' => 'AdminHomeController@adminAjaxAllUsers1'
	]);

	
});


/*End middleware check admin*/

/*Start middleware check sigin*/
Route::middleware(['auth'])->group(function () {
	Route::get('profile', [
		'as' => 'profile',
		function(){
			return redirect()->route('information');
		}
	]);
    Route::prefix('profile')->group(function () {
       	Route::get('information', [
			'as' => 'information',
			'uses' => 'UserController@indexInformation'
		]);

       	Route::post('information', [
			'as' => 'updateInformation',
			'uses' => 'UserController@updateInformation'
		]);
       	Route::get('changepassword', [
			'as' => 'changePassword',
			'uses' => 'UserController@indexChangePassword'
		]);

		Route::post('changepassword', [
			'as' => 'storeChangePassword',
			'uses' => 'UserController@storeChangePassword'
		]);

		Route::get('managequestion', 'UserController@indexManageQuestion')->name('manageQuestion');
		Route::post('removequestion', 'UserController@removeQuestion')->name('removeQuestion');
		Route::get('manageanswer', 'UserController@indexManageAnswer')->name('manageAnswer');
		Route::post('changeavatar', 'UserController@changeAvatar')->name('changeAvatar');

    });


    Route::post('logout',[
		'as'=>'logOut',
		'uses' => 'SignInController@logOut'
	]);

	

	Route::get('addtopic',[
		'as' => 'addTopic',
		'uses' => 'QuestionController@create'
	]);

	Route::post('addtopic','QuestionController@store');


	Route::get('edittopic/{id}',[
		'as' => 'editTopic',
		'uses' => 'QuestionController@edit'
	]);


	Route::post('edittopic','QuestionController@update');

	Route::post('deletetopic','QuestionController@destroy')->name('deleteTopic');

	Route::get('editanswer/{id}',[
		'as' => 'editAnswer',
		'uses' => 'AnswerController@edit'
	]);


	Route::post('editanswer','AnswerController@update');

	Route::post('addanswer','AnswerController@store')->name('addAnswer');

	Route::get('bestanswer/{id}',[
		'as' => 'bestAnswer',
		'uses' => 'ViewTopicController@bestAnswer'
	]);

	Route::get('removebestanswer/{id}',[
		'as' => 'removeBestAnswer',
		'uses' => 'ViewTopicController@removeBestAnswer'
	]);

	Route::get('like',[
		'as' => 'like',
		'uses' => 'ViewTopicController@like'
	]);


	Route::get('dislike',[
		'as' => 'dislike',
		'uses' => 'ViewTopicController@dislike'
	]);
	
	Route::get('removenotification/{id}','UserController@removeNotification')->name('removeNotification');

	Route::get('readnotification','UserController@readNotification')->name('readNotification');
});

/*End middleware check sign in*/

Route::fallback(function () {
    abort(404);
});	