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
	if(Auth::check()){
    		$user = Auth::user();
    		if($user->pq_maso == 'bgd')
    			return redirect()->route('getHomeBoGD');
    		else
    			return redirect()->route('getLogin');
    	}
    return view('trangchu');
}]);

Route::get('nganh-hoc',['as' => 'nganhhoc',  function () {
    return view('tuyensinh');
}]);

Route::get('dang-nhap', ['as' => 'getLogin', 'uses' => 'TaiKhoanController@getLogin']);
Route::post('dang-nhap', ['as' => 'postLogin', 'uses' => 'TaiKhoanController@postLogin']);
Route::get('dang-xuat',['as' => 'getLogout', 'uses' => 'TaiKhoanController@getLogout']);
Route::get('doi-mat-khau',['as' => 'getDoiMatKhau', 'uses' => 'TaiKhoanController@getDoiMatKhau']);

//controller bo giao duc
Route::get('bo-giao-duc', 
			['as' => 'getHomeBoGD', 
			'uses' => 'BoGDController@getHomeBoGD'])
			->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/thong-tin', 
			['as' => 'getThongTinBoGD', 
			'uses' => 'BoGDController@getThongTinBoGD'])
			->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/tao-tai-khoan', 
			['as' => 'getTaoTaiKhoan', 
			'uses' => 'BoGDController@getTaoTaiKhoan'])
			->middleware('xacthuc:bgd');

Route::post('bo-giao-duc/tao-tai-khoan', 
			['as' => 'postTaoTaiKhoan', 
			'uses' => 'BoGDController@postTaoTaiKhoan'])
			->middleware('xacthuc:bgd');

Route::post('tao-tai-khoan-excel', 
			['as' => 'postTaoTaiKhoanExcel', 
			'uses' => 'TaiKhoanController@postTaoTaiKhoanExcel'])
			->middleware('xacthuc:bgd:sgd');

Route::get('bo-giao-duc/tai-khoan/{q}', 
			['as' => 'getTaiKhoanSoGDDH', 
			'uses' => 'BoGDController@getTaiKhoanSoGDDH'])
			->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/quan-ly-thoi-gian', 
			['as' => 'getThoiGian', 
			'uses' => 'BoGDController@getThoiGian'])
			->middleware('xacthuc:bgd');

Route::post('bo-giao-duc/quan-ly-thoi-gian', 
			['as' => 'postThoiGian', 
			'uses' => 'BoGDController@postThoiGian'])
			->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/ql-khoi-nganh', 
			['as' => 'getKhoiNganh', 
			'uses' => 'BoGDController@getKhoiNganh'])
			->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/get-list-khoi-nganh', 
			['as' => 'getListKhoiNganh', 
			'uses' => 'BoGDController@getListKhoiNganh'])
			->middleware('xacthuc:bgd');

Route::post('bo-giao-duc/get-them-khoi-nganh', 
			['as' => 'getThemKhoiNganh', 
			'uses' => 'BoGDController@getThemKhoiNganh'])
			->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/get-list-mon-hoc', 
			['as' => 'getMonHoc', 
			'uses' => 'BoGDController@getMonHoc'])
			->middleware('xacthuc:bgd');

Route::post('bo-giao-duc/them-mon-hoc',
			['as' => 'postMonHoc',
			'uses' => 'BoGDController@postMonHoc'])
			->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/get-list-khoi', 
			['as' => 'getKhoi', 
			'uses' => 'BoGDController@getKhoi'])
			->middleware('xacthuc:bgd');

Route::post('bo-giao-duc/them-khoi',
			['as' => 'postKhoi',
			'uses' => 'BoGDController@postKhoi'])
			->middleware('xacthuc:bgd');

Route::post('bo-giao-duc/them-khoi-nganh',
			['as' => 'postKhoiNganh',
			'uses' => 'BoGDController@postKhoiNganh'])
			->middleware('xacthuc:bgd');

// het controller bo giao duc


//controller so giao duc

Route::get('so-giao-duc/thong-tin',
			['as' => 'getThongTinSoGD',
			'uses' => 'SoGDController@getThongTinSoGD'])
			->middleware('xacthuc:sgd');

Route::get('so-giao-duc/tai-khoan-thpt',
			['as' => 'getTaiKhoanTHPT',
			'uses' => 'SoGDController@getTaiKhoanTHPT'])
			->middleware('xacthuc:sgd');

Route::get('so-giao-duc/get-list-thpt',
			['as' => 'getListTHPT',
			'uses' => 'SoGDController@getListTHPT'])
			->middleware('xacthuc:sgd');

Route::post('so-giao-duc/them-thpt',
			['as' => 'postThemTHPT',
			'uses' => 'SoGDController@postThemTHPT'])
			->middleware('xacthuc:sgd');

Route::get('so-giao-duc/tai-khoan-hoc-sinh',
			['as' => 'getTaiKhoanHS',
			'uses' => 'SoGDController@getTaiKhoanHS'])
			->middleware('xacthuc:sgd');

Route::get('so-giao-duc/get-list-hs',
			['as' => 'getListHS',
			'uses' => 'SoGDController@getListHS'])
			->middleware('xacthuc:sgd');

Route::post('so-giao-duc/them-hs',
			['as' => 'postThemHS',
			'uses' => 'SoGDController@postThemHS'])
			->middleware('xacthuc:sgd');

Route::post('so-giao-duc/them-diem-excel',
			['as' => 'postThemDiemHSExcel',
			'uses' => 'SoGDController@postThemDiemHSExcel'])
			->middleware('xacthuc:sgd');			
			
			
//het controller so giao duc


//controller Dai Hoc
Route::get('dai-hoc/thong-tin',
			['as' => 'getThongTinDaiHoc',
			'uses' => 'DaiHocController@getThongTinDaiHoc'])
			->middleware('xacthuc:dh');

Route::get('dai-hoc/quan-ly-nganh',
			['as' => 'getNganh',
			'uses' => 'DaiHocController@getNganh'])
			->middleware('xacthuc:dh');

Route::get('dai-hoc/get-list-nganh',
			['as' => 'getListNganh',
			'uses' => 'DaiHocController@getListNganh'])
			->middleware('xacthuc:dh');

Route::post('dai-hoc/them-nganh',
			['as' => 'postThemNganh',
			'uses' => 'DaiHocController@postThemNganh'])
			->middleware('xacthuc:dh');

//Het controller dai hoc
Route::get('tuyen-sinh',['as' => 'tuyensinh', function () {
    return view('trangchu');
}]);

