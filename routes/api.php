<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('khoa')->group(function (){
        Route::get('getAll','KhoaController@getAll');
        Route::get('detail','KhoaController@detail');
        Route::post('create','KhoaController@createNew');
        Route::post('update','KhoaController@update');
        Route::post('delete','KhoaController@delete');
    });

    Route::prefix('bomon')->group(function (){
        Route::get('getAll','BoMonController@getAll');
        Route::get('detail','BoMonController@detail');
        Route::post('create','BoMonController@createNew');
        Route::post('update','BoMonController@update');
        Route::post('delete','BoMonController@delete');
    });

    

// });
