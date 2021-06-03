<?php

use App\Http\Controllers\ProvinceController;
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
    Route::get('/discussion-post', 'BaiVietController@getDiscussionPostList');
    Route::get('/teacher-post', 'BaiVietController@getTeacherPostList');
    Route::get('detail', 'BaiVietController@detailBoMon');
    Route::post('create', 'BaiVietController@createNewBoMon');   //chưa xong
    Route::post('update', 'BaiVietController@updateBoMon');      //chưa xong
    Route::post('delete', 'BaiVietController@deleteBoMon');
});

Route::prefix('khoa')->group(function () {
    Route::get('/', 'KhoaController@getAllKhoa');
    Route::get('detail', 'KhoaController@detailKhoa');
    Route::post('create', 'KhoaController@createNewKhoa');
    Route::put('update', 'KhoaController@updateKhoa');
    Route::delete('delete', 'KhoaController@deleteKhoa');
});
Route::prefix('bomon')->group(function () {
    Route::get('/', 'BoMonController@getAllBoMon');
    Route::get('detail', 'BoMonController@detailBoMon');
    Route::post('create', 'BoMonController@createNewBoMon');
    Route::put('update', 'BoMonController@updateBoMon');
    Route::delete('delete', 'BoMonController@deleteBoMon');
});

Route::prefix('sinhvien')->group(function () {
    Route::get('/', 'SinhVienController@getAllSinhVien');
    Route::get('/{id}', 'SinhVienController@detail');
    Route::post('/', 'SinhVienController@store');
    Route::post('/edit/{id}', 'SinhVienController@update');
    Route::post('/delete/{id}', 'SinhVienController@delete');
    Route::post('/search', 'SinhVienController@timkiemSV');
});

Route::apiResource('lophocphan', 'LopHocPhanController');
Route::apiResource('lophoc', 'LopHocController');
Route::apiResource('giangvien','GiangVienController');
Route::apiResource('monhoc','MonHocController');
Route::post('monhoc/search','MonHocController@timkiemMH');
// });
// Route::get('/home', 'HomeController@index');
Route::post('/login', 'AuthController@login');

Route::get('/province', 'ProvinceController@getProvince');
Route::get('/district', 'ProvinceController@getDistrict');
Route::get('/ward', 'ProvinceController@getWard');
