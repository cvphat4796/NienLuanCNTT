<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function getListMonHoc()
	{
		$listMH = DB::table('monhoc')->get();

		return Datatables::of($listMH)->make(true);
	}

	public function getThemKhoiNganh(Request $request)
	{
		if($request->querry == "insert"){
			$ctkhoi = DB::table('chitietkhoi')->select('khoi_maso')->groupBy('khoi_maso')->get()->toArray();       
	        $list_ma_khoi = array();
	        foreach ($ctkhoi as $k => $v) {
	        	$list_ma_khoi[] = $v->khoi_maso;

	        }
	        //dd($list_ma_khoi);
	        $khoi = DB::table('khoi')->whereNotIn('khoi_maso', $list_ma_khoi)->get();
		}
		else{
			$khoi = DB::table('khoi')->get();
		}
		
		return	response()->json(array('listKhoi' => $khoi));
	}

	public function getListKhoi()
	{
		$listKhoi = DB::table('khoi')->get();

		return Datatables::of($listKhoi)
							->editColumn('khoi_ten',function ($list)
							{
								return "Khối ".$list->khoi_ten;
							})
							->addColumn('action',function ($list)
							{
								return '<button type="button" onclick="editKhoi(this)" id="editKhoi'.$list->khoi_maso.'" data-ten="'.$list->khoi_ten.'" data-id="'.$list->khoi_maso.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i>Sửa</button>'.'<button type="button" onclick="deleteKhoi(this)" id="deleteKhoi'.$list->khoi_maso.'" data-id="'.$list->khoi_maso.'" data-ten="'.$list->khoi_ten.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i>Xóa</button>';
							})->make(true);
	}

	public function getListKhoiXetTuyen()
	{
		$listMH = collect([(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],
							(object)['khoi_ten'=>'A','mh_ten1'=>'Toan','mh_ten2'=>'Ly','mh_ten3'=>'Hoa'],]);
		//$listMH = DB::table('monhoc')->get();
		//dd($listMH);
		$arrKXT = DB::table('chitietkhoi')->get();
		return Datatables::of($listMH)
						->editColumn('khoi_ten', function($list) {
							return 'Khối '.$list->khoi_ten;
						})
						->addColumn('action',function ($list)
						{
							return $list->khoi_ten;
						})
						->make(true);
	}
}
