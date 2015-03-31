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

Route::group(array('prefix'=>'/auth'),function(){
    Route::get('/login',array('uses'=>'BackendController@login'));
    Route::post('/login',array('uses'=>'BackendController@loginPost'));
});

Route::group(array('prefix'=>'/admin'),function(){
    Route::get('/index',array('uses'=>'BackendController@index'));
    Route::get('/seller/list',array('uses'=>'BackendController@listSeller'));
    Route::get('/seller/add',array('uses'=>'BackendController@addSeller'));
    Route::post('/seller/add',array('uses'=>'BackendController@addSellerPost'));
    Route::post('/seller/update',array('uses'=>'BackendController@updateSellerPost'));
    Route::get('/goods/list/{sellerId}',array('uses'=>'BackendController@listGoods'));
    Route::post('/goods/add',array('uses'=>'BackendController@addGoodsPost'));
    Route::get('/user/list',array('uses'=>'BackendController@listUser'));
});
