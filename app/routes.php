<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', function()
{
	return Redirect::route('user');
});


Route::get('home', ['as'=>'user','uses' => 'SocialController@show']);

Route::get('login/fb', ['as'=>'login/fb','uses' => 'SocialController@loginWithFacebook']);
Route::get('login/gp', ['as'=>'login/gp','uses' => 'SocialController@loginWithGoogle']);
Route::get('login/tw', ['as'=>'login/tw','uses' => 'SocialController@loginWithTwitter']);
Route::get('login/gh', ['as'=>'login/gh','uses' => 'SocialController@loginWithGithub']);
Route::get('login/ln', ['as'=>'login/ln','uses' => 'SocialController@loginWithLinkedin']);

Route::get('logout', ['as' => 'logout', 'uses' => 'SocialController@logout']);

