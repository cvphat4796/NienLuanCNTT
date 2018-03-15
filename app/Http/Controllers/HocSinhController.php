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
    	
    	return View('hocsinh.nophoso');
    }

    public function getListNganh()
    {
    	$nganh =  DB::table('nganhhoc')
    							->join('khoinganh', 'khoinganh.ngh_id', '=', 'nganhhoc.ngh_id')
    							->join('khoi', 'khoi.khoi_maso', '=', 'khoinganh.khoi_maso')
    							->join('users as dh', 'dh.user_id', '=', 'nganhhoc.dh_maso')
    							->select('dh.user_name','nganhhoc.*','khoi.*')
    							->get();
    	
    	if(!$nganh->isEmpty()){
    		$id = $nganh[0]->ngh_id;
	 		$ngh_khoi = '- '.$nganh[0]->khoi_mota;
	 		$ma_khoi = $nganh[0]->khoi_maso.':';
	 		// dd( $nganh->count());
	    	for($i = 1; $i < $nganh->count();$i++){
	    		if($nganh[$i]->ngh_id != $id){
	    			$id = $nganh[$i]->ngh_id;
	    			$check_nganh = DB::table('nguyenvong')->where(['ngh_id'=>$nganh[$i-1]->ngh_id,
	    															'hs_maso' => Auth::user()->user_id])->first();
	    			//echo $id."==".is_null($check_nganh);
	    			if(!is_null($check_nganh)){
		    			$ok[] = [	'ngh_id' => $nganh[$i-1]->ngh_id,
		    						'ngh_maso' => $nganh[$i-1]->ngh_maso,
		    						'ngh_ten' => $nganh[$i-1]->ngh_ten,
		    						'ngh_chitieu' => $nganh[$i-1]->ngh_chitieu,
		    						'ngh_bachoc' => $nganh[$i-1]->ngh_bachoc,
		    						'ngh_khoi' => $ngh_khoi,
		    						'ngh_khoima' => $ma_khoi,
		    						'ngh_diemchuan' => $nganh[$i-1]->ngh_chuan,
		    						'dh_ten' => $nganh[$i-1]->user_name,
		    						'check' => 1,
	    							'douutien' => $check_nganh->nv_douutien,
	    							'khoi' => $check_nganh->khoi_maso
		    					];
	    			}
	    			else
	    			{
	    				$ok[] = [	'ngh_id' => $nganh[$i-1]->ngh_id,
		    						'ngh_maso' => $nganh[$i-1]->ngh_maso,
		    						'ngh_ten' => $nganh[$i-1]->ngh_ten,
		    						'ngh_chitieu' => $nganh[$i-1]->ngh_chitieu,
		    						'ngh_bachoc' => $nganh[$i-1]->ngh_bachoc,
		    						'ngh_khoi' => $ngh_khoi,
		    						'ngh_khoima' => $ma_khoi,
		    						'ngh_diemchuan' => $nganh[$i-1]->ngh_chuan,
		    						'dh_ten' => $nganh[$i-1]->user_name,
		    						'check' => 0
	    					];
	    			}
	    			$ngh_khoi = "";
	    			$ma_khoi = "";
	    		}
	    		
	    		$checkKhoi = DB::table('chitietkhoi')->where('khoi_maso',$nganh[$i]->khoi_maso)->first();
	    		if(!is_null($checkKhoi)){
	    			$ngh_khoi = $ngh_khoi.'- '.$nganh[$i]->khoi_mota;
	    			$ma_khoi = $ma_khoi.$nganh[$i]->khoi_maso.':';
	    		}
	    		if ($i == ($nganh->count()-1)) {
	    			$check_nganh = DB::table('nguyenvong')->where(['ngh_id'=>$nganh[$i]->ngh_id,
	    															'hs_maso' => Auth::user()->user_id])->first();
	    			if(!is_null($check_nganh)){
		    			$ok[] = [	'ngh_id' => $nganh[$i]->ngh_id,
		    						'ngh_maso' => $nganh[$i]->ngh_maso,
		    						'ngh_ten' => $nganh[$i]->ngh_ten,
		    						'ngh_chitieu' => $nganh[$i]->ngh_chitieu,
		    						'ngh_bachoc' => $nganh[$i]->ngh_bachoc,
		    						'ngh_khoi' => $ngh_khoi,
		    						'ngh_khoima' => $ma_khoi,
		    						'ngh_diemchuan' => $nganh[$i]->ngh_chuan,
		    						'dh_ten' => $nganh[$i]->user_name,
	    							'check' => 1,
	    							'douutien' => $check_nganh->nv_douutien,
	    							'khoi' => $check_nganh->khoi_maso
		    					];
		    		}
		    		else{
		    			$ok[] = [	'ngh_id' => $nganh[$i]->ngh_id,
	    						'ngh_maso' => $nganh[$i]->ngh_maso,
	    						'ngh_ten' => $nganh[$i]->ngh_ten,
	    						'ngh_chitieu' => $nganh[$i]->ngh_chitieu,
	    						'ngh_bachoc' => $nganh[$i]->ngh_bachoc,
	    						'ngh_khoi' => $ngh_khoi,
	    						'ngh_khoima' => $ma_khoi,
	    						'ngh_diemchuan' => $nganh[$i]->ngh_chuan,
	    						'dh_ten' => $nganh[$i]->user_name,
	    						'check' => 0
	    					];
		    		}
	    			$ngh_khoi = "";
	    			$ma_khoi = "";
	    		}
	    	}
	    	$ok = collect($ok);
    	}else{
    		$ok = collect([]);
    	}
    	return Datatables::of($ok)->make();
    }

    public function postNopHoSo(Request $request)
    {
    	$query = $request->querry;
    	switch ($query) {
    		case 'insert':
    			$mess = $this->insertHoSo($request);
    			break;
    		case 'update':
    			$mess = $this->updateHoSo($request);
    			break;
    		case 'delete':
    			$mess = $this->deleteHoSo($request);
    			break;

    	}
    	return response()->json($mess);
		
    }

    private function insertHoSo($request)
    {
    	$id_nganh = $request->id_nganh;
    	$khoi = $request->khoi;
    	$nguyen_vong = $request->nguyen_vong;
    	$hs = Auth::user()->user_id;
    	$nv = DB::table('nguyenvong')->where(['hs_maso'=>Auth::user()->user_id,
    											'nv_douutien' => $nguyen_vong])->get();
    	if(!$nv->isEmpty()){
    			return array('message' => 'Nguyện Vọng Bị Trùng!!','status' => false);
    	}
    	$diemhs = DB::table('diemthi')->where('hs_maso',Auth::user()->user_id)
    									->select('mh_maso')
    									->orderBY('mh_maso', 'desc')
    									->get();
    	
    	$ctk = DB::table('chitietkhoi')->where('khoi_maso',$khoi)
    									->select('mh_maso')
    									->orderBY('mh_maso', 'desc')->get();
    	$diem = [];
    	foreach ($diemhs as $key => $value) {
    		$diem[] = $value->mh_maso;
    	}
    	
    	$ct = [];
    	foreach ($ctk as $key => $value) {
    		$ct[] = $value->mh_maso;
    	}
    	
		if((count(array_diff( $diem,$ct))+3)==count($diem)){
			try {
				DB::beginTransaction();

				DB::table('nguyenvong')->insert([
												'hs_maso' => $hs,
												'ngh_id' => $id_nganh,
												'khoi_maso' => $khoi,
												'nv_douutien' => $nguyen_vong]);
	            
				DB::commit();
				
				return array('message' => 'Đăng Ký Thành Công!!','status' => true);
			} catch (\Exception $e) {
				DB::rollBack();
				return array('message' => 'Đăng Ký Thất Bại!!','status' => false);
			}
		}
		else{
			return array('message' => 'Bạn Không Đủ Số Môn Cho Tổ Hợp Môn Này!!','status' => false);
		}
    }

    private function updateHoSo($request)
    {
    	$id_nganh = $request->id_nganh;
    	$khoi = $request->khoi;
    	$nguyen_vong = $request->nguyen_vong; 
    	$nv = DB::table('nguyenvong')->where(['hs_maso'=>Auth::user()->user_id,
    											'ngh_id' => $id_nganh])->first();

    	if($nv->nv_douutien != $nguyen_vong){
    			$nv1 = DB::table('nguyenvong')->where(['hs_maso'=>Auth::user()->user_id,
    											'nv_douutien' => $nguyen_vong])->get();
		    	if(!$nv1->isEmpty()){
		    			return array('message' => 'Nguyện Vọng Bị Trùng!!','status' => false);
		    	}
    	}
    	try{
    			DB::beginTransaction();
				DB::table('nguyenvong')->where(['hs_maso'=>Auth::user()->user_id,
    											'ngh_id' => $id_nganh])
										->update(['khoi_maso' => $khoi,'nv_douutien' => $nguyen_vong]);
	            
				DB::commit();
    		return array('message' => 'Sửa Thành Công!!','status' => true);
    	}
    	catch (\Exception $e) {
			DB::rollBack();
			return array('message' => 'Sửa Thất Bại!!','status' => false);
		}
    }

    private function deleteHoSo($request)
    {
    	$id_nganh = $request->id_nganh;
    	try{
    			DB::beginTransaction();

				DB::table('nguyenvong')->where('ngh_id', $id_nganh)->delete();
	            
				DB::commit();
    		return array('message' => 'Xóa Thành Công!!','status' => true);
    	}
    	catch (\Exception $e) {
			DB::rollBack();
			return array('message' => 'Xóa Thất Bại!!','status' => false);
		}
    }
}
