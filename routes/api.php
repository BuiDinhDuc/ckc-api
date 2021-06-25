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
Route::prefix('giangvien')->group(function () {
    Route::get('/', 'GiangVienController@index');
    Route::post('store', 'GiangVienController@store');
    Route::get('detail/{id}', 'GiangVienController@show');
    Route::post('update/{id}', 'GiangVienController@update');
    Route::post('delete/{id}', 'GiangVienController@destroy');
    Route::post('lock/{id}', 'GiangVienController@lock');
    Route::post('unlock/{id}', 'GiangVienController@unlock');
    Route::get('getListGVByBoMon/{id}', 'GiangVienController@getListGVByBoMon');
    Route::get('index', 'GiangVienController@getAll');
    Route::post('search', 'GiangVienController@timkiemGV');
});

Route::prefix('sinhvien')->group(function () {
    Route::get('/', 'SinhVienController@index');
    Route::post('store', 'SinhVienController@store');
    Route::get('detail/{id}', 'SinhVienController@show');
    Route::post('update/{id}', 'SinhVienController@update');
    Route::post('delete/{id}', 'SinhVienController@destroy');
    Route::post('lock/{id}', 'SinhVienController@lock');
    Route::post('unlock/{id}', 'SinhVienController@unlock');
    Route::get('index', 'SinhVienController@getAll');
    Route::post('search', 'SinhVienController@timkiemSV');
    Route::get('getThongTin/{id}', 'SinhVienController@getThongTin');
});

Route::prefix('khoa')->group(function () {
    Route::get('/', 'KhoaController@index');
    Route::post('store', 'KhoaController@store');
    Route::get('detail/{id}', 'KhoaController@show');
    Route::post('update/{id}', 'KhoaController@update');
    Route::post('delete/{id}', 'KhoaController@destroy');
    Route::post('lock/{id}', 'KhoaController@lock');
    Route::post('unlock/{id}', 'KhoaController@unlock');
    Route::get('index', 'KhoaController@getAll');
    Route::post('search', 'KhoaController@timkiemKhoa');
});

Route::prefix('bomon')->group(function () {
    Route::get('/', 'BoMonController@index');
    Route::post('store', 'BoMonController@store');
    Route::get('detail/{id}', 'BoMonController@show');
    Route::post('update/{id}', 'BoMonController@update');
    Route::post('delete/{id}', 'BoMonController@destroy');
    Route::post('lock/{id}', 'BoMonController@lock');
    Route::post('unlock/{id}', 'BoMonController@unlock');
    Route::get('index', 'BoMonController@getAll');
    Route::post('search', 'BoMonController@timkiemBM');
});

Route::prefix('lophoc')->group(function () {
    Route::get('/', 'LopHocController@index');
    Route::get('detail/{id}', 'LopHocController@show');
    Route::post('store', 'LopHocController@store');
    Route::post('update/{id}', 'LopHocController@update');
    Route::post('delete/{id}', 'LopHocController@destroy');
    Route::get('getListLopByBoMonAndKhoa/{id}', 'LopHocController@getLopHocByBoMonAndKhoa');
    Route::post('lock/{id}', 'LopHocController@lock');
    Route::post('unlock/{id}', 'LopHocController@unlock');
    Route::post('search', 'LopHocController@timkiemLH');
    Route::get('index', 'LopHocController@getAll');
});
Route::prefix('monhoc')->group(function () {
    Route::get('/', 'MonHocController@index');
    Route::post('store', 'MonHocController@store');
    Route::get('detail/{id}', 'MonHocController@show');
    Route::post('update/{id}', 'MonHocController@update');
    Route::post('delete/{id}', 'MonHocController@destroy');
    Route::post('lock/{id}', 'MonHocController@lock');
    Route::post('unlock/{id}', 'MonHocController@unlock');
    Route::get('index', 'MonHocController@getAll');
    Route::post('search', 'MonHocController@timkiemMH');
});


Route::prefix('lophocphan')->group(function () {
    Route::get('/', 'LopHocPhanController@index');
    Route::get('detail/{id}', 'LopHocPhanController@show');
    Route::post('store', 'LopHocPhanController@store');
    Route::post('update/{id}', 'LopHocPhanController@update');
    Route::post('delete/{id}', 'LopHocPhanController@destroy');
    Route::post('lock/{id}', 'LopHocPhanController@lock');
    Route::post('unlock/{id}', 'LopHocPhanController@unlock');
    Route::get('index', 'LopHocPhanController@index');
    Route::post('search', 'LopHocPhanController@timkiemLHP');
    Route::get('/getLHPSV/{id}', 'LopHocPhanController@lstLopHocPhanTheoSV');
    Route::get('/getLHPGV/{id}', 'LopHocPhanController@lstLopHocPhanTheoGV');

    Route::post('themSV/{id}', 'LopHocPhanController@themSV');
    Route::post('khoaSV/{id}', 'LopHocPhanController@khoaSV');
    Route::post('moSV/{id}', 'LopHocPhanController@moSV');
});

Route::prefix('baiviet')->group(function () {
    Route::get('/discussion-post', 'BaiVietController@getDiscussionPostList');
    Route::get('/teacher-post', 'BaiVietController@getTeacherPostList');
    Route::get('detail', 'BaiVietController@detailBoMon');
    Route::post('create', 'BaiVietController@createNewBoMon');   //chưa xong
    Route::post('update', 'BaiVietController@updateBoMon');      //chưa xong
    Route::post('delete', 'BaiVietController@deleteBoMon');
});

Route::prefix('file')->group(function () {
    Route::get('/{id}', 'FileController@index');
    Route::post('uploadFile', 'FileController@store');
});

Route::prefix('chude')->group(function () {
    Route::post('store', 'ChuDeController@store');
    Route::get('index/{id}', 'ChuDeController@getAllChuDeTheoLHP');
});
// });
// Route::get('/home', 'HomeController@index');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

Route::get('/province', 'ProvinceController@getProvince');
Route::get('/district', 'ProvinceController@getDistrict');
Route::get('/ward', 'ProvinceController@getWard');
