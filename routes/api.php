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
    Route::post('importGiangVien', 'GiangVienController@importGiangVien');
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

    Route::post('importSinhVien', 'SinhVienController@importSinhVien');
    Route::get('countSinhVienByKhoa','SinhVienController@countSinhVienByKhoa');
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
    Route::get('/getLHPAdmin', 'LopHocPhanController@lstLopHocPhanTheoAdmin');
    Route::get('/getLHPLuuTruSV/{id}', 'LopHocPhanController@lstLopHocPhanLuuTruTheoSV');
    Route::get('/getLHPLuuTruGV/{id}', 'LopHocPhanController@lstLopHocPhanLuuTruTheoGV');
    Route::get('/getLHPLuuTruAdmin', 'LopHocPhanController@lstLopHocPhanLuuTruTheoAdmin');
    Route::post('themSV/{id}', 'LopHocPhanController@themSV');
    Route::post('khoaSV/{id}', 'LopHocPhanController@khoaSV');
    Route::post('moSV/{id}', 'LopHocPhanController@moSV');
    Route::post('getLHPTheoDSLop', 'LopHocPhanController@getLHPTheoDSLop');
    Route::post('luutru/{id}', 'LopHocPhanController@luuTru');
    Route::post('khoiphuc/{id}', 'LopHocPhanController@khoiPhuc');
    Route::post('thayDoiChinhSach/{id}', 'LopHocPhanController@thayDoiChinhSach');
    Route::get('getChinhSachLopHocPhan/{id}', 'LopHocPhanController@getChinhSachLopHocPhan');
});

Route::prefix('baiviet')->group(function () {
    Route::get('/discussion-post', 'BaiVietController@getDiscussionPostList');
    Route::get('/teacher-post', 'BaiVietController@getTeacherPostList');
    Route::get('baitap/{id}', 'BaiVietController@getBaiTap');
    Route::get('chitietbaitap/{id}', 'BaiVietController@getChiTietBaiTap');
    Route::get('hoclieu/{id}', 'BaiVietController@getHocLieu');
    Route::post('create', 'BaiVietController@createNewBoMon');   //chưa xong
    Route::post('update', 'BaiVietController@updateBoMon');      //chưa xong
    Route::post('delete', 'BaiVietController@deleteBoMon');
    Route::post('taoBaiTap', 'BaiVietController@taoBaiTap');
    Route::post('taoHocLieu', 'BaiVietController@taoHocLieu');
    Route::get('getBaiTap/{id}', 'BaiVietController@getAllBaiTap');
    Route::post('suaBaiTap/{id}', 'BaiVietController@suaBaiTap');
    Route::post('suaHocLieu/{id}', 'BaiVietController@suaHocLieu');
    Route::post('deleteBaiTap/{id}', 'BaiVietController@deleteBaiTap');
    Route::get('getBinhLuan/{id}', 'BaiVietController@getDSBinhLuan');
    Route::post('saveShareLink/{id}', 'BaiVietController@luuLinkShare');
    Route::post('getListFileChuaNop/{id}', 'BaiVietController@getListFileChuaNop');
    Route::post('saveFileBaiTap/{id}', 'BaiVietController@saveFileBaiTap');
    Route::post('deleteBaiLam/{id}', 'BaiVietController@deleteBaiLam');
    Route::post('nopbai/{id}', 'BaiVietController@nopbai');
    Route::post('getBaiLam/{id}', 'BaiVietController@getBaiLam');
    Route::get('getListDienDan/{id}', 'BaiVietController@getListDienDan');
    Route::post('xoadiendan/{id}', 'BaiVietController@xoaDienDan');
    Route::post('nopvanban/{id}', 'BaiVietController@nopvanban');

    Route::get('getDienDan/{id}', 'BaiVietController@getDienDan');
    Route::post('updateDienDan/{id}', 'BaiVietController@updateDienDan');
    Route::post('deleteFileBaiViet/{id}', 'BaiVietController@deleteFileBaiViet');
});

Route::prefix('file')->group(function () {
    Route::get('/{id}', 'FileController@index');
    Route::post('uploadFile', 'FileController@store');
    Route::post('uploadFileBaiLam', 'FileController@uploadFileBaiLam');
    Route::post('uploadFileTaoDienDan', 'FileController@uploadFileTaoDienDan');
});

Route::prefix('chude')->group(function () {
    Route::post('store', 'ChuDeController@store');
    Route::get('index/{id}', 'ChuDeController@getAllChuDeTheoLHP');
    Route::post('update/{id}', 'ChuDeController@update');
    Route::get('detail/{id}', 'ChuDeController@show');
    Route::post('delete/{id}', 'ChuDeController@destroy');
});

Route::prefix('binhluan')->group(function () {
    Route::post('store', 'BinhLuanController@store');
    Route::get('index/{id}', 'BinhLuanController@index');
    Route::post('update/{id}', 'BinhLuanController@update');
    Route::get('detail/{id}', 'BinhLuanController@show');
    Route::post('delete/{id}', 'BinhLuanController@destroy');
    Route::post('addBinhLuanBangTin', 'BinhLuanController@addBinhLuanBangTin');
});

Route::prefix('bangtin')->group(function () {
    Route::post('store', 'BangTinController@store');
    Route::get('index/{id}', 'BangTinController@index');
    Route::post('update/{id}', 'BangTinController@update');
    Route::get('detail/{id}', 'BangTinController@show');
    Route::post('delete/{id}', 'BangTinController@destroy');
});
// });
// Route::get('/home', 'HomeController@index');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');
Route::post('/doimatkhau/{id}', 'AuthController@doimatkhau');
Route::post('/taomaxacnhan', 'AuthController@taomaxacnhan');
Route::get('/getUser/{id}', 'AuthController@getUser');
Route::get('/province', 'ProvinceController@getProvince');
Route::get('/district', 'ProvinceController@getDistrict');
Route::get('/ward', 'ProvinceController@getWard');
Route::get('/demSL', 'AuthController@demSL');
