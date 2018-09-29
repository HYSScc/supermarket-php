<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () {
    Route::group(['namespace' => 'Home', 'prefix' => 'home'], function () {
        Route::group(['prefix' => 'goods'], function () {
            Route::get('list/{type}', 'GoodsController@listing');
            Route::any('buy/{gid}', 'GoodsController@buy');
        });
        Route::group(['prefix' => 'user'], function () {
            Route::get('orders', 'UserController@orders');
        });
    });

    Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
        Route::group(['prefix' => 'goods'], function () {
            Route::get('list/{type}', 'GoodsController@listing');
            Route::any('add/{type}', 'GoodsController@add');
            Route::any('stock/{gid}', 'GoodsController@stock');
        });
        Route::group(['prefix' => 'undercarriage'], function () {
            Route::any('goods/{gid}', 'UndercarriageController@undercarriage');
            Route::get('list', 'UndercarriageController@listing');
        });
        Route::group(['prefix' => 'sale/{period}'], function () {
            Route::get('list/{para}', 'SaleController@listView');
            Route::get('goods/{gid}', 'SaleController@goods');
            Route::get('export/{para}', 'SaleController@export');
        });
        Route::any('search/{type}', 'SearchController@search');
    });

    Route::get('logout', 'LogoutController@logout');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('test', function () {
    //
});
