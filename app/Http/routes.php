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
    Route::get('/logout',array('uses'=>'BackendController@logout'));
});

Route::group(array('domain'=>'','middleware'=>'isLogin'),function(){
    Route::group(array('prefix'=>'/admin','middleware'=>'isAdmin'),function(){
        Route::get('/index',array('uses'=>'BackendController@index'));

        Route::get('/seller/list',array('uses'=>'BackendController@listSeller'));
        Route::get('/seller/add',array('uses'=>'BackendController@addSeller'));
        Route::post('/seller/add',array('uses'=>'BackendController@addSellerPost'));
        Route::post('/seller/update',array('uses'=>'BackendController@updateSellerPost'));

        Route::get('/goods/list/{sellerId}',array('uses'=>'BackendController@listGoods'));
        Route::post('/goods/update',array('uses'=>'BackendController@updateGoodsPost'));
        Route::post('/goods/add',array('uses'=>'BackendController@addGoodsPost'));

        Route::get('/user/list',array('uses'=>'BackendController@listUser'));
        Route::get('/user/add',array('uses'=>'BackendController@addUser'));
        Route::post('/user/add',array('uses'=>'BackendController@addUserPost'));
        Route::post('/user/update',array('uses'=>'BackendController@updateUserPost'));

        Route::get('/department/list',array('uses'=>'BackendController@listDepartment'));
        Route::post('/department/add',array('uses'=>'BackendController@addDepartmentPost'));
        Route::post('/department/update',array('uses'=>'BackendController@updateDepartmentPost'));

        Route::get('/money/update',array('uses'=>'BackendController@updateMoney'));
        Route::post('/money/update',array('uses'=>'BackendController@updateMoneyPost'));

        Route::get('/order/list',array('uses'=>'BackendController@listOrder'));
        Route::post('/order/pass',array('uses'=>'BackendController@passOrder'));
        Route::post('/order/cancle',array('uses'=>'BackendController@cancleOrder'));

    });

    Route::get('/menu',array('uses'=>'BackendController@menu'));
    Route::get('/order/make',array('uses'=>'BackendController@makeOrder'));
    Route::post('/order/make',array('uses'=>'BackendController@makeOrderPost'));
    Route::get('/order/my',array('uses'=>'BackendController@myOrder'));
    Route::post('/order/cancel',array('uses'=>'BackendController@cancleOrder'));
    Route::get('/order/list',array('uses'=>'BackendController@listOrder'));

    Route::get('/record/my',array('uses'=>'BackendController@myRecord'));
});
