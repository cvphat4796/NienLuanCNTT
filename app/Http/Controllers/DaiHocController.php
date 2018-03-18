<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use App\Models\NganhHoc;

class DaiHocController extends Controller
{
    public function getThongTinDaiHoc()
    {
    	return View('truongdh.thongtin');
    }



    public function getNganh()
    {
    	
    	$nganh =  DB::table('nganhhoc')
    							->join('khoinganh', 'khoinganh.ngh_id', '=', 'nganhhoc.ngh_id')
    							->join('khoi', 'khoi.khoi_maso', '=', 'khoinganh.khoi_maso')
    							->where([
    									['dh_maso','=',Auth::user()->user_id]])->get();
  
            
    	$khois = DB::table('khoi')->join('chitietkhoi', 'khoi.khoi_maso', '=', 'chitietkhoi.khoi_maso')
    								->select('khoi.*')
    								->distinct()
    								->get();
    	 return View::make('truongdh.danhsachnganh')
				->with(compact('khois'));
    }

    public function getListNganh()
	{
		
    	$nganh =  DB::table('nganhhoc')
    							->join('khoinganh', 'khoinganh.ngh_id', '=', 'nganhhoc.ngh_id')
    							->join('khoi', 'khoi.khoi_maso', '=', 'khoinganh.khoi_maso')
    							->where([
    									['dh_maso','=',Auth::user()->user_id]])->get();
    	
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
	    						'ngh_diemchuan' => $nganh[$i-1]->ngh_chuan
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
	    						'ngh_diemchuan' => $nganh[$i]->ngh_chuan
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

	public function postThemNganh(Request $request)
	{

		$key = '';
		switch ($request->querry) {
			case 'insert':
				$key = 'Thêm';
				$status = $this->insertNganh($request);
				break;
			case 'update':
				$key = 'Sửa';
				$status = $this->updateNganh($request);
				break;
			case 'delete':
				$key = 'Xóa';
				$status = $this->deleteNganh($request);
				break;
		}


		if($status){
			$message = $key." Ngành Thành Công!!!";
			return response()->json(array('message' => $message,'status' => true));
		}
		else{
			$message = 'Lỗi '.$key;
			return response()->json(array('message' => $message,'status' => false));
		}
	}

	private function updateNganh($request)
	{
		$nganh_id = $request->nganh_id;
		$nganh_maso = $request->nganh_maso;
		$nganh_ten = $request->nganh_ten;
		$nganh_diemchuan = $request->nganh_diemchuan;
		$nganh_chitieu = $request->nganh_chitieu;
		$bachoc = $request->bh=="DH"?"Đại Học":"Cao Đẳng";

		$arrayKhoi = $request->khoi;

		try {
			DB::beginTransaction();

			DB::table('nganhhoc')->where('ngh_id',$nganh_id)->delete();

			DB::table('nganhhoc')->insert([
											'ngh_id' => $nganh_id,
											'ngh_maso' => $nganh_maso,
											'ngh_ten' => $nganh_ten,
											'ngh_chitieu' => $nganh_chitieu,
											'ngh_chuan' => $nganh_diemchuan,
											'ngh_bachoc' => $bachoc,
											'dh_maso' => Auth::user()->user_id
										]);
            foreach ($arrayKhoi as  $value) {
            	$khoiNganh[] = ['ngh_id' => $nganh_id, 'khoi_maso' => $value];
            }

            DB::table('khoinganh')->insert($khoiNganh);

			DB::commit();
			
			return true;
		} catch (\Exception $e) {
			DB::rollBack();
			return false;
		}
	}

	private function insertNganh($request)
	{
		$nganh_id = Uuid::generate()->string;
		$nganh_maso = $request->nganh_maso;
		$nganh_ten = $request->nganh_ten;
		$nganh_diemchuan = $request->nganh_diemchuan;
		$nganh_chitieu = $request->nganh_chitieu;
		$bachoc = $request->bh=="DH"?"Đại Học":"Cao Đẳng";

		$arrayKhoi = $request->khoi;

		try {
			DB::beginTransaction();

			DB::table('nganhhoc')->insert([
											'ngh_id' => $nganh_id,
											'ngh_maso' => $nganh_maso,
											'ngh_ten' => $nganh_ten,
											'ngh_chitieu' => $nganh_chitieu,
											'ngh_chuan' => $nganh_diemchuan,
											'ngh_bachoc' => $bachoc,
											'dh_maso' => Auth::user()->user_id
										]);
            foreach ($arrayKhoi as  $value) {
            	$khoiNganh[] = ['ngh_id' => $nganh_id, 'khoi_maso' => $value];
            }

            DB::table('khoinganh')->insert($khoiNganh);

			DB::commit();
			
			return true;
		} catch (\Exception $e) {
			DB::rollBack();
			return false;
		}
	}

	public function postListHoSo(Request $request)
	{
		$id = $request->id_nganh;
		$ng = DB::table('nguyenvong')->join('nganhhoc','nganhhoc.ngh_id','nguyenvong.ngh_id')
									->where('nguyenvong.ngh_id',$id)->orderBy('nv_douutien','asc')->get();
		$index = 1;	
		$ok = [];						
		foreach ($ng as $key => $value) {
			$diemhs = DB::table('diemthi')->where('hs_maso',$value->hs_maso)->get();
			$mon = DB::table('chitietkhoi')->where('khoi_maso',$value->khoi_maso)->get();
			$diem = 0;
			foreach ($mon as $k => $v) {
				foreach ($diemhs as $ke => $va) {
					if($v->mh_maso==$va->mh_maso){
						$diem += $va->dt_diemso;
						break;
					}
				}
			}
			$hs = DB::table('users')->where('user_id',$value->hs_maso)->first();
			
			$v = $value;
			$v->hs_ten = $hs->user_name;
			$v->hs_sdt = $hs->user_phone;
			$v->diem_hs = $diem;
			if($diem >= $v->ngh_chuan ){
				$v->kq = true;
			}
			else{
				$v->kq = false;
			}
			$index++;
			$ok[] = $v;
		}
		$kq = collect($ok)->sortByDesc('diem')->sortBy('nv_douutien')->sortByDesc('kq');
		return Datatables::of($kq)->removeColumn('ngh_bachoc')
									->removeColumn('ngh_id')
									->removeColumn('dh_maso')
									->removeColumn('ngh_chuan')
									->removeColumn('ngh_chitieu')
									->removeColumn('ngh_ten')
									->removeColumn('ngh_maso')->make();
	}

	public function getHoSo($id)
	{
		$ng = DB::table('nganhhoc')
									->where('nganhhoc.ngh_id',$id)->first();
		
		return  View::make('truongdh.hoso')
				->with(compact('ng'));
	}
}
