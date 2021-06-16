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

    //Giảng viên api
    Route::prefix('giangvien')->group(function(){
        Route::get('/','GiangVienController@index');
        Route::post('store','GiangVienController@store');
        Route::get('detail/{id}','GiangVienController@show');
        Route::post('update/{id}', 'GiangVienController@update');
        Route::post('delete/{id}', 'GiangVienController@destroy');

        Route::get('index','GiangVienController@getAll');
        Route::post('search','GiangVienController@timkiemGV');
    });

    Route::prefix('sinhvien')->group(function () {
        Route::get('/', 'SinhVienController@index');
        Route::post('store', 'SinhVienController@store');
        Route::get('detail/{id}', 'SinhVienController@show');
        Route::post('update/{id}', 'SinhVienController@update');
        Route::post('delete/{id}', 'SinhVienController@destroy');
      
        Route::get('index', 'SinhVienController@getAll');
        Route::post('search', 'SinhVienController@timkiemSV');
    });

    Route::prefix('khoa')->group(function () {
        Route::get('/', 'KhoaController@index');
        Route::post('store', 'KhoaController@store');
        Route::get('detail/{id}', 'KhoaController@show');
        Route::post('update/{id}', 'KhoaController@update');
        Route::post('delete/{id}', 'KhoaController@destroy');
    
        Route::get('index','KhoaController@getAll');
        Route::post('search','KhoaController@timkiemKhoa');
    });

    Route::prefix('bomon')->group(function () {
        Route::get('/', 'BoMonController@index');
        Route::post('store', 'BoMonController@store');
        Route::get('detail/{id}', 'BoMonController@show');
        Route::post('update/{id}', 'BoMonController@update');
        Route::post('delete/{id}', 'BoMonController@destroy');
       
        Route::get('index', 'BoMonController@getAll');
        Route::post('search','BoMonController@timkiemBM');
    });

    Route::prefix('lophoc')->group(function(){
        Route::get('/', 'LopHocController@index');
        Route::get('detail/{id}', 'LopHocController@show');
        Route::post('store', 'LopHocController@store');
        Route::post('update/{id}', 'LopHocController@update');
        Route::post('delete/{id}', 'LopHocController@destroy');

        Route::post('search','LopHocController@timkiemLH');
        Route::get('index','LopHocController@getAll');

    });

    Route::prefix('monhoc')->group(function(){
        Route::get('/','MonHocController@index');
        Route::post('store','MonHocController@store');
        Route::get('detail/{id}','MonHocController@show');
        Route::post('update/{id}', 'MonHocController@update');
        Route::post('delete/{id}', 'MonHocController@destroy');

        Route::get('index','MonHocController@getAll');
        Route::post('search','MonHocController@timkiemMH');
    });


    Route::prefix('lophocphan')->group(function () {
        Route::get('/', 'LopHocPhanController@index');
        Route::get('detail/{id}', 'LopHocPhanController@show');
        Route::post('store', 'LopHocPhanController@store');
        Route::post('update/{id}', 'LopHocPhanController@update');
        Route::post('delete/{id}', 'LopHocPhanController@destroy');

        Route::get('index', 'LopHocPhanController@index');
        Route::post('search','LopHocPhanController@timkiemLHP');
        Route::get('/getLHPSV/{id}','LopHocPhanController@lstLopHocPhanTheoSV');
        Route::get('/getLHPGV/{id}','LopHocPhanController@lstLopHocPhanTheoGV');
    });

    Route::prefix('baiviet')->group(function () {
        Route::get('/discussion-post', 'BaiVietController@getDiscussionPostList');
        Route::get('/teacher-post', 'BaiVietController@getTeacherPostList');
        Route::get('detail', 'BaiVietController@detailBoMon');
        Route::post('create', 'BaiVietController@createNewBoMon');   //chưa xong
        Route::post('update', 'BaiVietController@updateBoMon');      //chưa xong
        Route::post('delete', 'BaiVietController@deleteBoMon');
    });








// });
// Route::get('/home', 'HomeController@index');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

Route::get('/province', 'ProvinceController@getProvince');
Route::get('/district', 'ProvinceController@getDistrict');
Route::get('/ward', 'ProvinceController@getWard');
