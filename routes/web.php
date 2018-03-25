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

//route thoi gian
Route::get('bo-giao-duc/thoi-gian', 
			['as' => 'getThoiGianBoGD', 
			'uses' => 'BoGDController@getThoiGianBoGD'])
			->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/get-list-thoi-gian', 
			['as' => 'getListThoiGianBoGD', 
			'uses' => 'BoGDController@getListThoiGianBoGD'])
			->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/get-list-loai-thoi-gian', 
			['as' => 'getListLoaiThoiGianBoGD', 
			'uses' => 'BoGDController@getListLoaiThoiGianBoGD'])
			->middleware('xacthuc:bgd');

Route::post('bo-giao-duc/them-thoi-gian', 
			['as' => 'postThoiGian', 
			'uses' => 'BoGDController@postThoiGian'])
			->middleware('xacthuc:bgd');

//het route thoi gian

Route::get('bo-giao-duc', 
			['as' => 'getHomeBoGD', 
			'uses' => 'BoGDController@getHomeBoGD'])
			->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/tao-tai-khoan', 
			['as' => 'getTaoTaiKhoan', 
			'uses' => 'BoGDController@getTaoTaiKhoan'])
			->middleware('xacthuc:bgd');

Route::post('bo-giao-duc/tao-tai-khoan', 
			['as' => 'postTaoTaiKhoan', 
			'uses' => 'BoGDController@postTaoTaiKhoan'])
			->middleware('xacthuc:bgd');

//route tai khoan
Route::get('bo-giao-duc/tai-khoan/{q}', 
			['as' => 'getTaiKhoanSoGDDH', 
			'uses' => 'BoGDController@getTaiKhoanSoGDDH'])
			->middleware('xacthuc:bgd');

Route::post('bo-giao-duc/get-list-sgd-dh',[
			'as' => 'postListSGDDH',
			'uses' => 'BoGDController@postListSGDDH'])->middleware('xacthuc:bgd');


Route::get('bo-giao-duc/tai-khoan-thpt',[
			'as' => 'getTHPT',
			'uses' => 'BoGDController@getTHPT'])->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/get-list-thpt',[
			'as' => 'getListTHPT',
			'uses' => 'BoGDController@getListTHPT'])->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/tai-khoan-hs',[
			'as' => 'getHocSinh',
			'uses' => 'BoGDController@getHocSinh'])->middleware('xacthuc:bgd');

Route::get('bo-giao-duc/get-list-hoc-sinh',[
			'as' => 'getListHocSinh',
			'uses' => 'BoGDController@getListHocSinh'])->middleware('xacthuc:bgd');

Route::post('bo-giao-duc/sua-thong-tin',[
			'as' => 'postSuaThongTinSGDDH',
			'uses' => 'BoGDController@postSuaThongTinSGDDH'])->middleware('xacthuc:bgd');
//het route tai khoan


//route khoi nganh
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
// het route khoi nganh
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
			->middleware('xacthuc:bgd:sgd');

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
			->middleware('xacthuc:bgd:sgd');
		
			
Route::post('so-giao-duc/get-diem-hs',
			['as' => 'getDiemHS',
			'uses' => 'SoGDController@getDiemHS'])
			->middleware('xacthuc:sgd');	

Route::post('so-giao-duc/sua-diem',
			['as' => 'postSuaDiemHS',
			'uses' => 'SoGDController@postSuaDiemHS'])
			->middleware('xacthuc:sgd');			
//het controller so giao duc

//excel controller

Route::post('so-giao-duc/them-diem-excel',
			['as' => 'postThemDiemHSExcel',
			'uses' => 'ExcelController@postThemDiemHSExcel'])
			->middleware('xacthuc:sgd');	

			
Route::post('them-nganh-excel', 
			['as' => 'postThemNganhExcel', 
			'uses' => 'ExcelController@postThemNganhExcel'])
			->middleware('xacthuc:dh');

Route::post('them-diem-chuan-excel', 
			['as' => 'postDiemChuanExcel', 
			'uses' => 'ExcelController@postDiemChuanExcel'])
			->middleware('xacthuc:dh');

Route::post('tao-tai-khoan-excel', 
			['as' => 'postTaoTaiKhoanExcel', 
			'uses' => 'ExcelController@postTaoTaiKhoanExcel'])
			->middleware('xacthuc:bgd:sgd');
//het excel controller

//controller Dai Hoc
Route::get('dai-hoc/thong-tin',
			['as' => 'getThongTinDaiHoc',
			'uses' => 'DaiHocController@getThongTinDaiHoc'])
			->middleware('xacthuc:dh');

Route::get('dai-hoc/quan-ly-nganh',
			['as' => 'getNganh',
			'uses' => 'DaiHocController@getNganh'])
			->middleware('xacthuc:dh');

Route::get('dai-hoc/quan-ly-khoi',
			['as' => 'getKhoi',
			'uses' => 'DaiHocController@getKhoi'])
			->middleware('xacthuc:dh');

Route::post('dai-hoc/them-nganh',
			['as' => 'postThemNganh',
			'uses' => 'DaiHocController@postThemNganh'])
			->middleware('xacthuc:dh');

Route::post('dai-hoc/them-khoi',
			['as' => 'postThemKhoi',
			'uses' => 'DaiHocController@postThemKhoi'])
			->middleware('xacthuc:dh');

Route::post('dai-hoc/them-khoi-xet-tuyen',
			['as' => 'postThemKhoiXetTuyen',
			'uses' => 'DaiHocController@postThemKhoiXetTuyen'])
			->middleware('xacthuc:dh');

Route::get('dai-hoc/quan-ly-ho-so/{id}',
			['as' => 'getHoSo',
			'uses' => 'DaiHocController@getHoSo'])
			->middleware('xacthuc:dh');

Route::post('dai-hoc/get-list-ho-so',
			['as' => 'postListHoSo',
			'uses' => 'DaiHocController@postListHoSo'])
			->middleware('xacthuc:dh');

//Het controller dai hoc



//controller hoc sinh
Route::get('hoc-sinh/thong-tin',
			['as' => 'getThongTinHocSinh',
			'uses' => 'HocSinhController@getThongTinHocSinh'])
			->middleware('xacthuc:hs');

Route::get('hoc-sinh/danh-sach-nganh',
			['as' => 'getNganh',
			'uses' => 'HocSinhController@getNganh'])
			->middleware('xacthuc:hs');

Route::get('hoc-sinh/get-list-nganh',
			['as' => 'getListNganh',
			'uses' => 'HocSinhController@getListNganh'])
			->middleware('xacthuc:hs');

Route::post('hoc-sinh/nop-ho-so',
			['as' => 'postNopHoSo',
			'uses' => 'HocSinhController@postNopHoSo'])
			->middleware('xacthuc:hs');

//het controller hoc sinh	


//controller api
Route::post('tra-diem',['as' => 'TraDiem', 'uses' => 'ApiController@TraDiem']);

Route::get('api-dc/get-nganh',
			['as' => 'getNganh',
			'uses' => 'ApiController@getNganh']);

Route::get('api-dc/get-list-mon-hoc',
			['as' => 'getListMonHoc',
			'uses' => 'ApiController@getListMonHoc'])
			->middleware('xacthuc:dh');

Route::get('api-dc/get-list-khoi-xet-tuyen',
			['as' => 'getListKhoiXetTuyen',
			'uses' => 'ApiController@getListKhoiXetTuyen'])
			->middleware('xacthuc:dh');

Route::get('api-dc/get-list-khoi',
			['as' => 'getListKhoi',
			'uses' => 'ApiController@getListKhoi'])
			->middleware('xacthuc:dh');


Route::post('api-dc/get-them-khoi-nganh', 
			['as' => 'getThemKhoiNganh', 
			'uses' => 'ApiController@getThemKhoiNganh'])
			->middleware('xacthuc:dh');

Route::get('api-dc/get-list-nganh',
			['as' => 'getListNganh',
			'uses' => 'ApiController@getListNganh'])
			->middleware('xacthuc:dh');

//het controller api		
Route::get('tuyen-sinh',['as' => 'tuyensinh', function () {
    return view('trangchu');
}]);

