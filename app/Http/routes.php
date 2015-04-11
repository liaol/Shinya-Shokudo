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

        Route::group(array('prefix'=>'/seller'),function(){
            Route::get('/list',array('uses'=>'BackendController@listSeller'));
            Route::get('/add',array('uses'=>'BackendController@addSeller'));
            Route::post('/add',array('uses'=>'BackendController@addSellerPost'));
            Route::post('/update',array('uses'=>'BackendController@updateSellerPost'));
            Route::get('/addbyurl',array('uses'=>'BackendController@addSellerByUrl'));
            Route::post('/addbyurl',array('uses'=>'BackendController@addSellerByUrlPost'));
        });

        Route::group(array('prefix'=>'/goods'),function(){
            Route::get('/list/{sellerId}',array('uses'=>'BackendController@listGoods'));
            Route::post('/update',array('uses'=>'BackendController@updateGoodsPost'));
            Route::post('/add',array('uses'=>'BackendController@addGoodsPost'));
        });

        Route::group(array('prefix'=>'/user'),function(){
            Route::get('/list',array('uses'=>'BackendController@listUser'));
            Route::get('/add',array('uses'=>'BackendController@addUser'));
            Route::post('/add',array('uses'=>'BackendController@addUserPost'));
            Route::get('/update/{userId}',array('uses'=>'BackendController@updateUser'));
            Route::post('/update',array('uses'=>'BackendController@updateUserPost'));
            Route::post('/resetpassword',array('uses'=>'BackendController@resetPassword'));
            Route::get('/record/{userId}',array('uses'=>'BackendController@userRecord'));
            Route::get('/order/{userId}',array('uses'=>'BackendController@userOrder'));
        });

        Route::group(array('prefix'=>'/department'),function(){
            Route::get('/list',array('uses'=>'BackendController@listDepartment'));
            Route::post('/add',array('uses'=>'BackendController@addDepartmentPost'));
            Route::post('/update',array('uses'=>'BackendController@updateDepartmentPost'));
        });

        Route::group(array('prefix'=>'/money'),function(){
            Route::get('/update',array('uses'=>'BackendController@updateMoney'));
            Route::post('/update',array('uses'=>'BackendController@updateMoneyPost'));
        });

        Route::group(array('prefix'=>'/order'),function(){
            Route::get('/list',array('uses'=>'BackendController@listOrder'));
            Route::post('/list',array('uses'=>'BackendController@listOrder'));
            Route::post('/pass',array('uses'=>'BackendController@passOrder'));
            Route::post('/passall',array('uses'=>'BackendController@passAllOrder'));
        });

        Route::group(array('prefix'=>'/time'),function(){
            Route::get('/set',array('uses'=>'BackendController@setTime'));
            Route::post('/set',array('uses'=>'BackendController@setTimePost'));
        });

    });

    Route::get('/menu',array('uses'=>'BackendController@menu'));
    Route::get('/order/make',array('uses'=>'BackendController@makeOrder'));
    Route::post('/order/make',array('uses'=>'BackendController@makeOrderPost'));
    Route::get('/order/my',array('uses'=>'BackendController@myOrder'));
    Route::post('/order/cancel',array('uses'=>'BackendController@cancelOrder'));
    Route::get('/order/list',array('uses'=>'BackendController@listOrder'));
    Route::get('/record/my',array('uses'=>'BackendController@myRecord'));
});














