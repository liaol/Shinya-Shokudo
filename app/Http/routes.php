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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(array('perfix'=>'/auth'),function(){
    Route::get('/login',array('uses'=>'BackendController@login'));
    Route::post('/login',array('uses'=>'BackendController@loginPost'));
});

Route::group(array('perfix'=>'/admin'),function(){
    Route::get('/index',array('uses'=>'BackendController@index'));
    Route::get('/seller/list',array('uses'=>'BackendController@sellerList'));
    Route::get('/goods/list/{sellerId}',array('uses'=>'BackendController@goodsList'));
    Route::get('/user/list',array('uses'=>'BackendController@userList'));
});
