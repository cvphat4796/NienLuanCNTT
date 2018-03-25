<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ApiController extends Controller
{

	public function TraDiem(Request $request)
	{
		$sbd = $request->sbd;
		$query = 'select * from diemthi LEFT JOIN monhoc on monhoc.mh_maso=diemthi.mh_maso WHERE diemthi.hs_maso="'.$sbd.'"';
		$diem = DB::select(DB::raw($query ));
		return View::make('trangchu')
				->with(compact('diem'));
	}

	public function getNganh()
	{
		//lay du lieu ve nganh cua truong dai hoc
    	$nganh =  DB::table('nganhhoc')
    							->join('users','users.user_id','nganhhoc.dh_maso')
    							->join('nganhxettuyen', 'nganhxettuyen.ngh_id', '=', 'nganhhoc.ngh_id')
    							->join('khoi', 'khoi.khoi_maso', '=', 'nganhxettuyen.khoi_maso')
    							->orderBy('nganhxettuyen.ngh_id','asc')
    							->get();
    	
    	//kiem tra co nganh khong
    	if(!$nganh->isEmpty()){
    		$id = $nganh[0]->ngh_id;
    		//lay ten cac mon hoc trong khoi xet tuyen dau tien
	 		$khoi_mh = DB::table('chitietkhoi')->join('monhoc','monhoc.mh_maso','chitietkhoi.mh_maso')
	 											->where('chitietkhoi.khoi_maso',$nganh[0]->khoi_maso)
	 											->select('monhoc.mh_ten')
	 											->get();
	 		$mh_temp = '';
	 		foreach ($khoi_mh as $key => $value) {
	 			if($value->mh_ten == $khoi_mh->last()->mh_ten){
	    			$mh_temp = $mh_temp.$value->mh_ten;
	    		}
	    		else{
	    			$mh_temp = $mh_temp.$value->mh_ten.',';
	    		}
	 		}
	 		$ngh_khoi = $nganh[0]->khoi_ten.':'.$mh_temp.';';
	 		$mh_temp = '';
	 		$ma_khoi = $nganh[0]->khoi_maso.':';


	 		//vong lap tach khoi xet tuyen cho nganh
	    	for($i = 1; $i < $nganh->count();$i++){
	    		//neu id nganh thu i khac voi id truoc thi luu lai
	    		if($nganh[$i]->ngh_id != $id){
	    			$id = $nganh[$i]->ngh_id;
	    			//lay cac chuyen nganh trong nganh
	    			$chuyenNganh = DB::table('chuyennganh')->where('ngh_id',$nganh[$i-1]->ngh_id)->get();
	    			$ten_nganh = $nganh[$i-1]->ngh_ten;
	    			if(!$chuyenNganh->isEmpty()){
	    				$temp = '';
	    				foreach ($chuyenNganh as $key => $value) {
	    					if($value->cn_ten == $chuyenNganh->last()->cn_ten){
	    						$temp = $temp.$value->cn_ten;
	    					}
	    					else{
	    						$temp = $temp.$value->cn_ten.','; 
	    					}
	    					
	    				}
	    				$ten_nganh = $ten_nganh.':'.$temp;
	    			}
	    			//luu vao mang
	    			$ok[] = (object)[	
	    						'ngh_id' => $nganh[$i-1]->ngh_id,
	    						'ngh_maso' => $nganh[$i-1]->ngh_maso,
	    						'dh_ten' => $nganh[$i-1]->user_name,
	    						'ngh_ten' => $ten_nganh,
	    						'ngh_chitieu' => $nganh[$i-1]->ngh_chitieu,
	    						'ngh_bachoc' => $nganh[$i-1]->ngh_bachoc,
	    						'tohopmon' => $ngh_khoi,
	    						'thm_maso' => $ma_khoi,
	    						'ngh_diemchuan' => $nganh[$i-1]->ngh_diemchuan
	    					];
	    			$ngh_khoi = "";
	    			$ma_khoi = "";
	    			
	    		}
	    		
	    		//lay cac khoi xet tuyen cua nganh thu i
	    		$khoi_mh = DB::table('chitietkhoi')->join('monhoc','monhoc.mh_maso','chitietkhoi.mh_maso')
	 											->where('chitietkhoi.khoi_maso',$nganh[$i]->khoi_maso)
	 											->select('monhoc.mh_ten')
	 											->get();
	    		if(!is_null($khoi_mh)){
	    			$mh_temp = '';
			 		foreach ($khoi_mh as $key => $value) {
			 			if($value->mh_ten == $khoi_mh->last()->mh_ten){
			    			$mh_temp = $mh_temp.$value->mh_ten;
			    		}
			    		else{
			    			$mh_temp = $mh_temp.$value->mh_ten.', ' ;
			    		}
			 			
			 		}
			 		$ngh_khoi = $ngh_khoi.$nganh[$i]->khoi_ten.':'.$mh_temp.';';
			 		$mh_temp = '';
			 		$ma_khoi = $ma_khoi.$nganh[$i]->khoi_maso.':';
	    		}

	    		//luu nganh cuoi cung trong danh sach truy xuat vao mang
	    		if ($i == ($nganh->count()-1)) {
	    			$chuyenNganh = DB::table('chuyennganh')->where('ngh_id',$nganh[$i]->ngh_id)->get();
	    			$ten_nganh = $nganh[$i]->ngh_ten;
	    			if(!$chuyenNganh->isEmpty()){
	    				$temp = '';
	    				foreach ($chuyenNganh as $key => $value) {
	    					if($value->cn_ten == $chuyenNganh->last()->cn_ten){
	    						$temp = $temp.$value->cn_ten;
	    					}
	    					else{
	    						$temp = $temp.$value->cn_ten.', '; 
	    					}
	    				}
	    				$ten_nganh = $ten_nganh.':'.$temp;
	    			}
	    			$ok[] =  (object)[	'ngh_id' => $nganh[$i]->ngh_id,
	    						'ngh_maso' => $nganh[$i]->ngh_maso,
	    						'ngh_ten' => $ten_nganh,
	    						'ngh_chitieu' => $nganh[$i]->ngh_chitieu,
	    						'dh_ten' => $nganh[$i-1]->user_name,
	    						'ngh_bachoc' => $nganh[$i]->ngh_bachoc,
	    						'tohopmon' => $ngh_khoi,
	    						'thm_maso' => $ma_khoi,
	    						'ngh_diemchuan' => $nganh[$i]->ngh_diemchuan
	    					];
	    			$ngh_khoi = "";
	    			$ma_khoi = "";
	    		}
	    		
	    	}//het vong for tach khoi vao nganh
	    	$ok = collect($ok);
    	}else{
    		$ok = collect([]);
    	}
    	
    	return Datatables::of($ok)
    			->editColumn('tohopmon',function ($list)
    			{
    				$thm = explode(";", $list->tohopmon);
    				if(count($thm) > 1){
    					$temp = '';
    					foreach ($thm as $value) {
    						if($value != ''){
    							if($value == end($thm))
	    						{
	    							$temp = $temp.'- '.$value;
	    						}
	    						else{
	    							$temp = $temp.'- '.$value.'</br>';
	    						}
    						}
    						
    					}
    					return $temp;
    				}
    				return $list->tohopmon;
    			})
    			->editColumn('ngh_ten',function ($list)
    			{
    				$ten = explode(":", $list->ngh_ten);
    				if(count($ten) == 2){
    					$cn = explode(',',$ten[1]);
    					$temp = '<b>'.$ten[0].'</b>, <i> có '.count($cn).' chuyên ngành</i></br>';
    					foreach ($cn as $value) {
    						if($value == end($cn))
    						{
    							$temp = $temp.'- '.$value;
    						}
    						else{
    							$temp = $temp.'- '.$value.'</br>';
    						}
    					}
    					return $temp;
    				}
    				return '<b>'.$list->ngh_ten.'</b>';
    				
    				
    			})
    			->rawColumns(['tohopmon', 'ngh_ten'])
                ->make(true);
    	
	}
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


	public function getListNganh()
	{
		//lay du lieu ve nganh cua truong dai hoc
    	$nganh =  DB::table('nganhhoc')
    							->join('nganhxettuyen', 'nganhxettuyen.ngh_id', '=', 'nganhhoc.ngh_id')
    							->join('khoi', 'khoi.khoi_maso', '=', 'nganhxettuyen.khoi_maso')
    							->where([
    									['nganhhoc.dh_maso','=',Auth::user()->user_id]])->get();
    	//kiem tra co nganh khong
    	if(!$nganh->isEmpty()){
    		$id = $nganh[0]->ngh_id;
    		//lay ten cac mon hoc trong khoi xet tuyen dau tien
	 		$khoi_mh = DB::table('chitietkhoi')->join('monhoc','monhoc.mh_maso','chitietkhoi.mh_maso')
	 											->where('chitietkhoi.khoi_maso',$nganh[0]->khoi_maso)
	 											->select('monhoc.mh_ten')
	 											->get();
	 		$mh_temp = '';
	 		foreach ($khoi_mh as $key => $value) {
	 			if($value->mh_ten == $khoi_mh->last()->mh_ten){
	    			$mh_temp = $mh_temp.$value->mh_ten;
	    		}
	    		else{
	    			$mh_temp = $mh_temp.$value->mh_ten.',';
	    		}
	 		}
	 		$ngh_khoi = $nganh[0]->khoi_ten.':'.$mh_temp.';';
	 		$mh_temp = '';
	 		$ma_khoi = $nganh[0]->khoi_maso.':';


	 		//vong lap tach khoi xet tuyen cho nganh
	    	for($i = 1; $i < $nganh->count();$i++){
	    		//neu id nganh thu i khac voi id truoc thi luu lai
	    		if($nganh[$i]->ngh_id != $id){
	    			$id = $nganh[$i]->ngh_id;
	    			//lay cac chuyen nganh trong nganh
	    			$chuyenNganh = DB::table('chuyennganh')->where('ngh_id',$nganh[$i-1]->ngh_id)->get();
	    			$ten_nganh = $nganh[$i-1]->ngh_ten;
	    			if(!$chuyenNganh->isEmpty()){
	    				$temp = '';
	    				foreach ($chuyenNganh as $key => $value) {
	    					if($value->cn_ten == $chuyenNganh->last()->cn_ten){
	    						$temp = $temp.$value->cn_ten;
	    					}
	    					else{
	    						$temp = $temp.$value->cn_ten.','; 
	    					}
	    					
	    				}
	    				$ten_nganh = $ten_nganh.':'.$temp;
	    			}
	    			//luu vao mang
	    			$ok[] = (object)[	
	    						'ngh_id' => $nganh[$i-1]->ngh_id,
	    						'ngh_maso' => $nganh[$i-1]->ngh_maso,
	    						'ngh_ten' => $ten_nganh,
	    						'ngh_chitieu' => $nganh[$i-1]->ngh_chitieu,
	    						'ngh_bachoc' => $nganh[$i-1]->ngh_bachoc,
	    						'tohopmon' => $ngh_khoi,
	    						'thm_maso' => $ma_khoi,
	    						'ngh_diemchuan' => $nganh[$i-1]->ngh_diemchuan
	    					];
	    			$ngh_khoi = "";
	    			$ma_khoi = "";
	    			
	    		}
	    		
	    		//lay cac khoi xet tuyen cua nganh thu i
	    		$khoi_mh = DB::table('chitietkhoi')->join('monhoc','monhoc.mh_maso','chitietkhoi.mh_maso')
	 											->where('chitietkhoi.khoi_maso',$nganh[$i]->khoi_maso)
	 											->select('monhoc.mh_ten')
	 											->get();
	    		if(!is_null($khoi_mh)){
	    			$mh_temp = '';
			 		foreach ($khoi_mh as $key => $value) {
			 			if($value->mh_ten == $khoi_mh->last()->mh_ten){
			    			$mh_temp = $mh_temp.$value->mh_ten;
			    		}
			    		else{
			    			$mh_temp = $mh_temp.$value->mh_ten.', ' ;
			    		}
			 			
			 		}
			 		$ngh_khoi = $ngh_khoi.$nganh[$i]->khoi_ten.':'.$mh_temp.';';
			 		$mh_temp = '';
			 		$ma_khoi = $ma_khoi.$nganh[$i]->khoi_maso.':';
	    		}

	    		//luu nganh cuoi cung trong danh sach truy xuat vao mang
	    		if ($i == ($nganh->count()-1)) {
	    			$chuyenNganh = DB::table('chuyennganh')->where('ngh_id',$nganh[$i]->ngh_id)->get();
	    			$ten_nganh = $nganh[$i]->ngh_ten;
	    			if(!$chuyenNganh->isEmpty()){
	    				$temp = '';
	    				foreach ($chuyenNganh as $key => $value) {
	    					if($value->cn_ten == $chuyenNganh->last()->cn_ten){
	    						$temp = $temp.$value->cn_ten;
	    					}
	    					else{
	    						$temp = $temp.$value->cn_ten.', '; 
	    					}
	    				}
	    				$ten_nganh = $ten_nganh.':'.$temp;
	    			}
	    			$ok[] =  (object)[	'ngh_id' => $nganh[$i]->ngh_id,
	    						'ngh_maso' => $nganh[$i]->ngh_maso,
	    						'ngh_ten' => $ten_nganh,
	    						'ngh_chitieu' => $nganh[$i]->ngh_chitieu,
	    						'ngh_bachoc' => $nganh[$i]->ngh_bachoc,
	    						'tohopmon' => $ngh_khoi,
	    						'thm_maso' => $ma_khoi,
	    						'ngh_diemchuan' => $nganh[$i]->ngh_diemchuan
	    					];
	    			$ngh_khoi = "";
	    			$ma_khoi = "";
	    		}
	    		
	    	}//het vong for tach khoi vao nganh
	    	$ok = collect($ok);
    	}else{
    		$ok = collect([]);
    	}
    	return Datatables::of($ok)
    			->editColumn('tohopmon',function ($list)
    			{
    				$thm = explode(";", $list->tohopmon);
    				if(count($thm) > 1){
    					$temp = '';
    					foreach ($thm as $value) {
    						if($value != ''){
    							if($value == end($thm))
	    						{
	    							$temp = $temp.'- '.$value;
	    						}
	    						else{
	    							$temp = $temp.'- '.$value.'</br>';
	    						}
    						}
    						
    					}
    					return $temp;
    				}
    				return $list->tohopmon;
    			})
    			->editColumn('ngh_ten',function ($list)
    			{
    				$ten = explode(":", $list->ngh_ten);
    				if(count($ten) == 2){
    					$cn = explode(',',$ten[1]);
    					$temp = '<b>'.$ten[0].'</b>, <i> có '.count($cn).' chuyên ngành</i></br>';
    					foreach ($cn as $value) {
    						if($value == end($cn))
    						{
    							$temp = $temp.'- '.$value;
    						}
    						else{
    							$temp = $temp.'- '.$value.'</br>';
    						}
    					}
    					return $temp;
    				}
    				return '<b>'.$list->ngh_ten.'</b>';
    				
    				
    			})
    			->addColumn('action',function ($list)
    			{
    				$button = '<button type="button" onclick="editNganh(this)" id="editNganh'.$list->ngh_id.'" 			data-maso="'.$list->ngh_maso.'" 
    							data-ten="'.$list->ngh_ten.'" 
								data-id="'.$list->ngh_id.'" 
								data-chitieu="'.$list->ngh_chitieu.'" 
								data-bachoc="'.$list->ngh_bachoc.'"
								data-tohopmon="'.$list->tohopmon.'" 
								data-thm_maso="'.$list->thm_maso.'"
								data-ngh_diemchuan="'.$list->ngh_diemchuan.'" 
								class="btn btn-xs btn-primary">
								<i class="glyphicon glyphicon-edit"></i>Sửa</button>'.
							'<button type="button" onclick="deleteNganh(this)" id="deleteNganh'.$list->ngh_id.'" data-id="'.$list->ngh_id.'" 
								data-ten="'.$list->ngh_ten.'"
								class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i>Xóa</button>';
    				if(SoGDController::checkTime('LTG03','giua') || SoGDController::checkTime('LTG03','cuoi')){
    					$button = $button.'<a href=/dai-hoc/quan-ly-ho-so/'.$list->ngh_id.' class="btn btn-xs btn-success">Chi Tiết</a>';
    				}
    				return $button;
    			})
    			->rawColumns(['tohopmon', 'ngh_ten','action'])
                ->make(true);
    	
	}
}
