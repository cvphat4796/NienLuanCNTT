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
		$listMH = DB::table('monhoc')->orderBy('mh_ten','desc')->get();
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
	        $khoi = DB::table('khoi')->whereNotIn('khoi_maso', $list_ma_khoi)->orderBy('khoi_ten','asc')->get();
		}
		else{
			$khoi = DB::table('khoi')->orderBy('khoi_ten','asc')->get();
		}
		
		return	response()->json(array('listKhoi' => $khoi));
	}

	public function getListKhoi()
	{
		$listKhoi = DB::table('khoi')->orderBy('khoi_ten','asc')->get();
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
	
		$arrKXT = DB::table('chitietkhoi')->join('khoi','khoi.khoi_maso','chitietkhoi.khoi_maso')
											->join('monhoc','monhoc.mh_maso','chitietkhoi.mh_maso')
											->orderBy('chitietkhoi.khoi_maso','asc')
											->get();
		$KXT = [];
		$temp = [];
		if(!$arrKXT->isEmpty()){

			for($j = 0; $j < count($arrKXT);$j=$j+3){
				$temp = $arrKXT->where('khoi_maso', $arrKXT[$j]->khoi_maso);
				$arrOK['khoi_maso'] = $arrKXT[$j]->khoi_maso;
				$arrOK['khoi_ten'] = $arrKXT[$j]->khoi_ten;
				$dem = 0;
				for($i = $j; $i < ($j + 3); $i++){
					$dem++;
					$arrOK['mh_maso'.($dem)]=$temp[$i]->mh_maso;
					$arrOK['mh_ten'.($dem)]=$temp[$i]->mh_ten;
				}
				$KXT[] = (object)$arrOK;
				$arrOK = null;
			}			
		}

		return Datatables::of(collect($KXT))
						->editColumn('khoi_ten', function($list) {
							return 'Khối '.$list->khoi_ten;
						})
						->addColumn('action',function ($list)
						{
							return '<button type="button" onclick="editKXT(this)" id="editKXT'.$list->khoi_maso.'" data-ten="'.$list->khoi_ten.'" 
								data-id="'.$list->khoi_maso.'" 
								data-mon1="'.$list->mh_maso1.'" 
								data-mon2="'.$list->mh_maso2.'" 
								data-mon3="'.$list->mh_maso3.'" 
								class="btn btn-xs btn-primary">
								<i class="glyphicon glyphicon-edit"></i>Sửa</button>'.
								'<button type="button" onclick="deleteKXT(this)" id="deleteKXT'.$list->khoi_maso.'" data-id="'.$list->khoi_maso.'" 
								data-ten="'.$list->khoi_ten.'"
								class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i>Xóa</button>';
						})
						->make(true);
	}
}
