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

Route::get('/', 'BackendController@index');

Route::group(array('prefix'=>'/auth'),function(){
    Route::get('/login',array('uses'=>'BackendController@login'));
    Route::post('/login',array('uses'=>'BackendController@loginPost'));
    Route::group(['middleware'=>'isLogin'],function(){
        Route::get('/logout',array('uses'=>'BackendController@logout'));
        Route::get('/password/update',array('uses'=>'BackendController@updatePassword'));
        Route::post('/password/update',array('uses'=>'BackendController@updatePasswordPost'));
    });
});

Route::group(array('domain'=>'','middleware'=>'isLogin'),function(){
    Route::group(array('prefix'=>'/admin','middleware'=>'isAdmin'),function(){
        Route::get('/index',array('uses'=>'BackendController@index'));

        Route::get('/seller/list',array('uses'=>'BackendController@listSeller'));
        Route::get('/seller/add',array('uses'=>'BackendController@addSeller'));
        Route::post('/seller/add',array('uses'=>'BackendController@addSellerPost'));
        Route::post('/seller/update',array('uses'=>'BackendController@updateSellerPost'));
        Route::get('/seller/addbyurl',array('uses'=>'BackendController@addSellerByUrl'));
        Route::post('/seller/addbyurl',array('uses'=>'BackendController@addSellerByUrlPost'));

        Route::get('/goods/list/{sellerId}',array('uses'=>'BackendController@listGoods'));
        Route::post('/goods/update',array('uses'=>'BackendController@updateGoodsPost'));
        Route::post('/goods/add',array('uses'=>'BackendController@addGoodsPost'));

        Route::get('/user/list',array('uses'=>'BackendController@listUser'));
        Route::get('/user/add',array('uses'=>'BackendController@addUser'));
        Route::post('/user/add',array('uses'=>'BackendController@addUserPost'));
        Route::post('/user/update',array('uses'=>'BackendController@updateUserPost'));
        Route::post('/user/resetpassword',array('uses'=>'BackendController@resetPassword'));
        Route::get('/user/record/{userId}',array('uses'=>'BackendController@userRecord'));
        Route::get('/user/order/{userId}',array('uses'=>'BackendController@userOrder'));

        Route::get('/department/list',array('uses'=>'BackendController@listDepartment'));
        Route::post('/department/add',array('uses'=>'BackendController@addDepartmentPost'));
        Route::post('/department/update',array('uses'=>'BackendController@updateDepartmentPost'));

        Route::get('/money/update',array('uses'=>'BackendController@updateMoney'));
        Route::post('/money/update',array('uses'=>'BackendController@updateMoneyPost'));

        Route::get('/order/list',array('uses'=>'BackendController@listOrder'));
        Route::post('/order/list',array('uses'=>'BackendController@listOrder'));
        Route::post('/order/pass',array('uses'=>'BackendController@passOrder'));
        Route::post('/order/passall',array('uses'=>'BackendController@passAllOrder'));

        Route::get('/time/set',array('uses'=>'BackendController@setTime'));
        Route::post('/time/set',array('uses'=>'BackendController@setTimePost'));

    });

    Route::get('/menu',array('uses'=>'BackendController@menu'));
    Route::get('/order/make',array('uses'=>'BackendController@makeOrder'));
    Route::post('/order/make',array('uses'=>'BackendController@makeOrderPost'));
    Route::get('/order/my',array('uses'=>'BackendController@myOrder'));
    Route::post('/order/cancel',array('uses'=>'BackendController@cancelOrder'));
    Route::get('/order/list',array('uses'=>'BackendController@listOrder'));

    Route::get('/record/my',array('uses'=>'BackendController@myRecord'));
});














