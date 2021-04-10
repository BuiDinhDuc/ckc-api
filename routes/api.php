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
Route::prefix('khoa')->group(function () {
    Route::get('getAll', 'KhoaController@getAllKhoa');
    Route::get('detail', 'KhoaController@detailKhoa');
    Route::post('create', 'KhoaController@createNewKhoa');
    Route::post('update', 'KhoaController@updateKhoa');
    Route::post('delete', 'KhoaController@deleteKhoa');
});
Route::prefix('bomon')->group(function () {
    Route::get('getAll', 'BoMonController@getAllBoMon');
    Route::get('detail', 'BoMonController@detailBoMon');
    Route::post('create', 'BoMonController@createNewBoMon');
    Route::post('update', 'BoMonController@updateBoMon');
    Route::post('delete', 'BoMonController@deleteBoMon');
});

    

// });
