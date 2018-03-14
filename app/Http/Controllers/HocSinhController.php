<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;

class HocSinhController extends Controller
{
    public function getThongTinHocSinh()
    {
    	$hocsinhs = DB::table('hocsinh')->join('users','users.user_id','=','hocsinh.hs_maso')
    									->join('khuvuc','khuvuc.kv_maso','=','hocsinh.kv_maso')
    									->join('users as thpt','thpt.user_id','=','hocsinh.thpt_maso')
    									->select('hocsinh.*','users.*','thpt.user_name as thpt_ten','khuvuc.*')
    									->where('hocsinh.hs_maso',Auth::user()->user_id)
    									->get()[0];

    	$query = 'select * from diemthi LEFT JOIN monhoc on monhoc.mh_maso=diemthi.mh_maso WHERE diemthi.hs_maso="'.Auth::user()->user_id.'"';
        
         $diem = DB::select(DB::raw($query ));
    									//dd($diem);
    	return View::make('hocsinh.thongtin')
				->with(compact('hocsinhs'))
				->with(compact('diem'));
    }

    public function getNganh()
    {
    	$daihoc = DB::table('users')->where('pq_maso','dh')->get();
    	return View::make('hocsinh.nophoso')
				->with(compact('daihoc'));
    }

    public function getListNganh()
    {
    	$nganh =  DB::table('nganhhoc')
    							->join('khoinganh', 'khoinganh.ngh_id', '=', 'nganhhoc.ngh_id')
    							->join('khoi', 'khoi.khoi_maso', '=', 'khoinganh.khoi_maso')
    							->join('users as dh', 'dh.user_id', '=', 'nganhhoc.dh_maso')
    							->get();
    	
    	if(!$nganh->isEmpty()){
    		$id = $nganh[0]->ngh_id;
	 		$ngh_khoi = '- '.$nganh[0]->khoi_mota;
	 		$ma_khoi = $nganh[0]->khoi_maso.':';
	 		// dd( $nganh->count());
	    	for($i = 1; $i < $nganh->count();$i++){
	    		if($nganh[$i]->ngh_id != $id){
	    			$id = $nganh[$i]->ngh_id;
	    			$ok[] = [	'ngh_id' => $nganh[$i-1]->ngh_id,
	    						'ngh_maso' => $nganh[$i-1]->ngh_maso,
	    						'ngh_ten' => $nganh[$i-1]->ngh_ten,
	    						'ngh_chitieu' => $nganh[$i-1]->ngh_chitieu,
	    						'ngh_bachoc' => $nganh[$i-1]->ngh_bachoc,
	    						'ngh_khoi' => $ngh_khoi,
	    						'ngh_khoima' => $ma_khoi,
	    						'ngh_diemchuan' => $nganh[$i-1]->ngh_chuan,
	    						'dh_ten' => $nganh[$i-1]->user_name
	    					];
	    			$ngh_khoi = "";
	    			$ma_khoi = "";
	    		}
	    		
	    		$checkKhoi = DB::table('chitietkhoi')->where('khoi_maso',$nganh[$i]->khoi_maso)->first();
	    		if(!is_null($checkKhoi)){
	    			$ngh_khoi = $ngh_khoi.'- '.$nganh[$i]->khoi_mota;
	    			$ma_khoi = $ma_khoi.$nganh[$i]->khoi_maso.':';
	    		}
	    		if ($i == ($nganh->count()-1)) {
	    			$ok[] = [	'ngh_id' => $nganh[$i]->ngh_id,
	    						'ngh_maso' => $nganh[$i]->ngh_maso,
	    						'ngh_ten' => $nganh[$i]->ngh_ten,
	    						'ngh_chitieu' => $nganh[$i]->ngh_chitieu,
	    						'ngh_bachoc' => $nganh[$i]->ngh_bachoc,
	    						'ngh_khoi' => $ngh_khoi,
	    						'ngh_khoima' => $ma_khoi,
	    						'ngh_diemchuan' => $nganh[$i]->ngh_chuan,
	    						'dh_ten' => $nganh[$i]->user_name
	    					];
	    			$ngh_khoi = "";
	    			$ma_khoi = "";
	    		}
	    		
	    	}
	    	$ok = collect($ok);
    	}else{
    		$ok = collect([]);
    	}
    	
    	
    	return Datatables::of($ok)
                ->make();
    }
}
