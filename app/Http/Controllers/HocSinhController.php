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
    									->first();

    	$diem = DB::table('diemthi')->leftJoin('monhoc', 'monhoc.mh_maso', '=', 'diemthi.mh_maso')
									->where('diemthi.hs_maso',Auth::user()->user_id)->get();
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
    							->join('nganhxettuyen', 'nganhxettuyen.ngh_id', '=', 'nganhhoc.ngh_id')
    							->join('khoi', 'khoi.khoi_maso', '=', 'nganhxettuyen.khoi_maso')
    							->join('users as dh', 'dh.user_id', '=', 'nganhhoc.dh_maso')
    							->select('dh.user_name','nganhhoc.*','khoi.*')
    							->get();
    	
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
	 		
	    	for($i = 1; $i < $nganh->count();$i++){
	    		if($nganh[$i]->ngh_id != $id){
	    			$id = $nganh[$i]->ngh_id;
	    			$check_nganh = DB::table('nguyenvong')->where(['ngh_id'=>$nganh[$i-1]->ngh_id,
	    															'hs_maso' => Auth::user()->user_id])->first();
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


	    			if(!is_null($check_nganh)){
		    			$ok[] = (object)[	'ngh_id' => $nganh[$i-1]->ngh_id,
		    						'ngh_maso' => $nganh[$i-1]->ngh_maso,
		    						'ngh_ten' => $ten_nganh,
		    						'ngh_chitieu' => $nganh[$i-1]->ngh_chitieu,
		    						'ngh_bachoc' => $nganh[$i-1]->ngh_bachoc,
		    						'ngh_khoi' => $ngh_khoi,
		    						'ngh_khoima' => $ma_khoi,
		    						'ngh_diemchuan' => $nganh[$i-1]->ngh_diemchuan,
		    						'dh_ten' => $nganh[$i-1]->user_name,
		    						'check' => 1,
	    							'douutien' => $check_nganh->nv_douutien,
	    							'khoi' => $check_nganh->khoi_maso
		    					];
	    			}
	    			else
	    			{
	    				$ok[] = (object)[	'ngh_id' => $nganh[$i-1]->ngh_id,
		    						'ngh_maso' => $nganh[$i-1]->ngh_maso,
		    						'ngh_ten' => $ten_nganh,
		    						'ngh_chitieu' => $nganh[$i-1]->ngh_chitieu,
		    						'ngh_bachoc' => $nganh[$i-1]->ngh_bachoc,
		    						'ngh_khoi' => $ngh_khoi,
		    						'ngh_khoima' => $ma_khoi,
		    						'ngh_diemchuan' => $nganh[$i-1]->ngh_diemchuan,
		    						'douutien' => 'Không Đăng Ký',
		    						'dh_ten' => $nganh[$i-1]->user_name,
		    						'check' => 0
	    					];
	    			}
	    			$ngh_khoi = "";
	    			$ma_khoi = "";
	    		}
	    		$khoi_mh = DB::table('chitietkhoi')->join('monhoc','monhoc.mh_maso','chitietkhoi.mh_maso')
	 											->where('chitietkhoi.khoi_maso',$nganh[$i]->khoi_maso)
	 											->select('monhoc.mh_ten')
	 											->get();
	    		if(!$khoi_mh->isEmpty()){
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
	    			$check_nganh = DB::table('nguyenvong')->where(['ngh_id'=>$nganh[$i]->ngh_id,
	    															'hs_maso' => Auth::user()->user_id])->first();
	    			if(!is_null($check_nganh)){
		    			$ok[] = (object)[	'ngh_id' => $nganh[$i]->ngh_id,
		    						'ngh_maso' => $nganh[$i]->ngh_maso,
		    						'ngh_ten' => $ten_nganh,
		    						'ngh_chitieu' => $nganh[$i]->ngh_chitieu,
		    						'ngh_bachoc' => $nganh[$i]->ngh_bachoc,
		    						'ngh_khoi' => $ngh_khoi,
		    						'ngh_khoima' => $ma_khoi,
		    						'ngh_diemchuan' => $nganh[$i]->ngh_diemchuan,
		    						'dh_ten' => $nganh[$i]->user_name,
	    							'check' => 1,
	    							'douutien' => $check_nganh->nv_douutien,
	    							'khoi' => $check_nganh->khoi_maso
		    					];
		    		}
		    		else{
		    			$ok[] = (object)[	'ngh_id' => $nganh[$i]->ngh_id,
	    						'ngh_maso' => $nganh[$i]->ngh_maso,
	    						'ngh_ten' => $ten_nganh,
	    						'ngh_chitieu' => $nganh[$i]->ngh_chitieu,
	    						'ngh_bachoc' => $nganh[$i]->ngh_bachoc,
	    						'ngh_khoi' => $ngh_khoi,
	    						'ngh_khoima' => $ma_khoi,
	    						'douutien' => 'Không Đăng Ký',
	    						'ngh_diemchuan' => $nganh[$i]->ngh_diemchuan,
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
  

    	return Datatables::of($ok)
    						->editColumn('ngh_khoi',function ($list)
    						{
    							$thm = explode(";", $list->ngh_khoi);
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
			    				if(SoGDController::checkTime('LTG03','cuoi')){
			    					$kq = DB::table('nguyenvong')->where([['hs_maso','=',Auth::user()->user_id],
			    														['ngh_id','=',$list->ngh_id]])->first();
			    					if(!is_null($kq)){
										if($kq->nv_kq === 1){
				    						return '<span class="text-success">Đậu</span>';
				    					}
										else{
											return '<span class="text-danger">Rớt</span>';
										}
			    					}
			    						return '<span class="text-warning">Không Nộp</span>';
			    				}
			    				else if(SoGDController::checkTime('LTG03','giua')){

			    					if($list->check == 0){
					                    return '<button onclick="nopNganh(this)" '
					                    .'data-idnganh="'.$list->ngh_id.'"'
					                    .'data-manganh="'.$list->ngh_maso.'"'
					                    .'data-tennganh="'.$list->ngh_ten.'"'
					                    .'data-tohopmon="'.$list->ngh_khoi.'"'
					                    .'data-khoi="'.$list->ngh_khoima.'"'
					                    .'id="nopNganh-'.$list->ngh_id.'"' 
					                    .' class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Nộp Hồ Sơ</button>';
					                }
					                else{
					                	 return '<button onclick="suaNganh(this)" '
					                    .'data-idnganh="'.$list->ngh_id.'"'
					                    .'data-tennganh="'.$list->ngh_ten.'"'
					                    .'data-tohopmon="'.$list->ngh_khoi.'"'
					                    .'data-khoi="'.$list->ngh_khoima.'"'
					                    .'data-nv="'.$list->douutien.'"'
					                    .'id="suaNganh-'.$list->ngh_id.'"' 
					                    .' class="btn btn-xs btn-success"><i class="glyphicon glyphicon-pencil"></i> Sửa Hồ Sơ</button>'
					                    .'<br/>'
					                    . '<button onclick="rutNganh(this)" '
					                    .'data-idnganh="'.$list->ngh_id.'"'
					                    .'data-tennganh="'.$list->ngh_ten.'"'
					                    .'id="rutNganh-'.$list->ngh_id.'"' 
					                    .' class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Rút Hồ Sơ</button>';
					                }
			    				}

			    				return '';
			    			})
    						->rawColumns(['ngh_khoi','ngh_ten','action'])
    						->make(true);
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
