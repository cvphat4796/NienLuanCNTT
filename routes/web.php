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

Route::get('/',['as' => 'trangchu',  function () {
    return view('trangchu');
}]);

Route::get('nganh-hoc',['as' => 'nganhhoc',  function () {
    return view('tuyensinh');
}]);

Route::get('dang-nhap', ['as' => 'getLogin', 'uses' => 'TaiKhoanController@getLogin']);
Route::post('dang-nhap', ['as' => 'postLogin', 'uses' => 'TaiKhoanController@postLogin']);
Route::get('dang-xuat',['as' => 'getLogout', 'uses' => 'TaiKhoanController@getLogout']);
Route::get('doi-mat-khau',['as' => 'getDoiMatKhau', 'uses' => 'TaiKhoanController@getDoiMatKhau']);

Route::get('bo-giao-duc', ['as' => 'getHomeBoGD', 'uses' => 'BoGDController@getHomeBoGD'])->middleware('xacthuc:bgd');
Route::get('bo-giao-duc/tao-tai-khoan', ['as' => 'getTaoTaiKhoan', 'uses' => 'BoGDController@getTaoTaiKhoan'])->middleware('xacthuc:bgd');

Route::post('bo-giao-duc/tao-tai-khoan', ['as' => 'postTaoTaiKhoan', 'uses' => 'BoGDController@postTaoTaiKhoan'])->middleware('xacthuc:bgd');

Route::post('bo-giao-duc/tao-tai-khoan-excel', ['as' => 'postTaoTaiKhoanExcel', 'uses' => 'BoGDController@postTaoTaiKhoanExcel'])->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/tai-khoan-sogd', ['as' => 'getTaiKhoanSoGD', 'uses' => 'BoGDController@getTaiKhoanSoGD'])->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/tai-khoan-dh', ['as' => 'getTaiKhoanDH', 'uses' => 'BoGDController@getTaiKhoanDH'])->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/quan-ly-thoi-gian', ['as' => 'getThoiGian', 'uses' => 'BoGDController@getThoiGian'])->middleware('xacthuc:bgd');

Route::post('bo-giao-duc/quan-ly-thoi-gian', ['as' => 'postThoiGian', 'uses' => 'BoGDController@postThoiGian'])->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/ql-khoi-nganh', ['as' => 'getKhoiNganh', 'uses' => 'BoGDController@getKhoiNganh'])->middleware('xacthuc:bgd');

Route::get('tuyen-sinh',['as' => 'tuyensinh', function () {
    return view('trangchu');
}]);

