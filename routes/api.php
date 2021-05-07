<?php

use App\Http\Controllers\SinhVienController;
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
Route::prefix('baiviet')->group(function () {
    Route::get('/', 'BaiVietController@getAllB');
    Route::get('detail', 'BoMonController@detailBoMon');
    Route::post('create', 'BoMonController@createNewBoMon');
    Route::post('update', 'BoMonController@updateBoMon');
    Route::post('delete', 'BoMonController@deleteBoMon');
});

Route::prefix('khoa')->group(function () {
    Route::get('/', 'KhoaController@getAllKhoa');
    Route::get('detail', 'KhoaController@detailKhoa');
    Route::post('create', 'KhoaController@createNewKhoa');
    Route::post('update', 'KhoaController@updateKhoa');
    Route::post('delete', 'KhoaController@deleteKhoa');
});
Route::prefix('bomon')->group(function () {
    Route::get('/', 'BoMonController@getAllBoMon');
    Route::get('detail', 'BoMonController@detailBoMon');
    Route::post('create', 'BoMonController@createNewBoMon');
    Route::post('update', 'BoMonController@updateBoMon');
    Route::post('delete', 'BoMonController@deleteBoMon');
});

Route::prefix('sinhvien')->group(function () {
    Route::get('/', 'SinhVienController@getAllSinhVien');
    Route::get('/{id}', 'SinhVienController@detail');
});

Route::get('/home', 'HomeController@index');
Route::post('/login', 'AuthController@login');

    

// });
