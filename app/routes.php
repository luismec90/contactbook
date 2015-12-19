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


Route::group(['before' => 'guest'], function () {

    Route::get('login', ['as' => 'login_path', 'uses' => 'AuthController@showLogin']);
    Route::post('login', ['as' => 'login_path', 'uses' => 'AuthController@postLogin']);


    Route::get('signup', ['as' => 'signup_path', 'uses' => 'AuthController@showSignup']);
    Route::post('signup', ['as' => 'signup_path', 'uses' => 'AuthController@postSignup']);

    Route::get('auth/github', 'AuthController@github');
    Route::get('auth/facebook', 'AuthController@facebook');
});

Route::group(['before' => 'auth'], function () {

    Route::get('logout', ['as' => 'logout_path', 'uses' => 'AuthController@logout']);

    Route::get('/', ['as' => 'home_path', 'uses' => 'HomeController@index']);
    Route::resource('contacts', 'ContactController');
});



