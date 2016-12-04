<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

	Route::post('/auth/checkemail', 'AuthController@checkemail');	
	Route::group(['middleware' => ['web']], function () {
		
		Route::get('/bet','BetController@index');
		Route::post('/music/cancelvoteofcomment','MusicController@cancelvoteofcomment');
		Route::post('/music/cancelvoteofanswer','MusicController@cancelvoteofanswer');
		Route::post('/music/deletecomment','MusicController@deletecomment');
		Route::post('/music/deleteanswer','MusicController@deleteanswer');
		Route::post('/music/deletequestion','MusicController@deletequestion');
		Route::get('/music/delete','MusicController@delete');
		Route::get('/music/profile','MusicController@profile');
		Route::get('/music/index','MusicController@index');
		Route::get('/','BetController@index');

		
		Route::get('/login','AuthController@loginform');
		Route::get('auth/login','AuthController@loginform');
		Route::get('auth/logout','AuthController@logout');	
		Route::post('auth/authenticate','AuthController@authenticate');
		Route::post('auth/register','AuthController@register');
		Route::post('auth/token','AuthController@token');
		Route::get('auth/verify/{username}/{token}','AuthController@verify');
		Route::get('auth/forgot','AuthController@forgot');
		Route::post('auth/change','AuthController@change');
		Route::get('auth/reset/{username}/{token}','AuthController@reset');
		Route::get('auth/login-facebook','AuthController@redirectToProvider');
		Route::get('auth/callback', 'AuthController@handleProviderCallback');
		Route::get('auth/google-login', 'AuthController@googleLogin');
		Route::get('auth/google-callback', 'AuthController@googleCallback');

		Route::post('music/upvoteanswer','MusicController@upvoteanswer');
		Route::post('music/downvoteanswer','MusicController@downvoteanswer');
		Route::post('music/upvotecomment','MusicController@upvotecomment');
		Route::post('music/downvotecomment','MusicController@downvotecomment');
		Route::post('music/addanswer','MusicController@addanswer');
		Route::post('music/addcomment','MusicController@addcomment');
		Route::post('music/addquestion','MusicController@addquestion');
		Route::post('bet/add-players','BetController@addPlayers');
		Route::post('bet/highest-scorer','BetController@highestScorer');
	
	Route::group(['middleware' => ['auth']], function () {
			Route::post('/bet/process-team','BetController@processTeam');
	});

	Route::group(['middleware' => ['App\Http\Middleware\Adminmiddleware']], function () {
		Route::post('/bet/add-match','BetController@addMatch');
		Route::post('/bet/update-value','BetController@updateValue');
		Route::post('/bet/result','BetController@result');
	});
});
		


