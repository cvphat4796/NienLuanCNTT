<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
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
    							->join('nganhxettuyen', 'nganhxettuyen.ngh_id', '=', 'nganhhoc.ngh_id')
    							->join('khoi', 'khoi.khoi_maso', '=', 'nganhxettuyen.khoi_maso')
    							->where([
    									['nganhxettuyen.dh_maso','=',Auth::user()->user_id]])->get();
  
            
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
    							->join('nganhxettuyen', 'nganhxettuyen.ngh_id', '=', 'nganhhoc.ngh_id')
    							->join('khoi', 'khoi.khoi_maso', '=', 'nganhxettuyen.khoi_maso')
    							->where([
    									['nganhxettuyen.dh_maso','=',Auth::user()->user_id]])->get();
    	
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



	//action khoi xet tuyen
	public function getKhoi()
	{
		$mh = DB::table('monhoc')->orderBy('mh_ten','asc')->get();
		return View::make('truongdh.khoixettuyen')->with(compact('mh'));
	}

	public function postThemKhoiXetTuyen(Request $request)
	{
		$key = "";
		switch ($request->querry) {
			case 'insert':
				$status = $this->insertKhoiXetTuyen($request);
				break;
			case 'update':
				$status = $this->updateKhoiXetTuyen($request);
				break;
			case 'delete':
				$status = $this->deleteKhoiXetTuyen($request);
				break;
			default:
				return redirect()->back();
				break;
		}
		return	response()->json($status);
	}

	private function deleteKhoiXetTuyen($request)
	{
		$khoi_maso = $request->khoi;
		DB::beginTransaction();
		try{
			DB::table('chitietkhoi')->where('khoi_maso',$khoi_maso)->delete();
			
			DB::commit();
			return array('message' => "Xóa Khối Xét Tuyển Thành Công!!!" );
		}
		catch(\Exception $e){
			DB::rollBack();
			return array('message' => "Xóa Khối Xét Tuyển Thất Bại!!!" );
		}
	}

	private function updateKhoiXetTuyen($request)
	{
		$khoi_maso = $request->khoi;
		$mon1 = $request->mon1;
		$mon2 = $request->mon2;
		$mon3 = $request->mon3;	

		DB::beginTransaction();
		try{
			DB::table('chitietkhoi')->where('khoi_maso',$khoi_maso)->delete();
			DB::table('chitietkhoi')->insert([
				['khoi_maso' => $request->khoi, 'mh_maso' => $request->mon1],
				['khoi_maso' => $request->khoi, 'mh_maso' => $request->mon2],
				['khoi_maso' => $request->khoi, 'mh_maso' => $request->mon3],
			]);
			DB::commit();
			return array('message' => "Sửa Khối Xét Tuyển Thành Công!!!" );
		}
		catch(\Exception $e){
			
			DB::rollBack();
			return array('message' => "Sửa Khối Xét Tuyển Thất Bại!!!" );
		}
	}

	private function insertKhoiXetTuyen($request)
	{
		$mon1 = $request->mon1;
		$mon2 = $request->mon2;
		$mon3 = $request->mon3;		
		DB::beginTransaction();
		try{

			DB::table('chitietkhoi')->insert([
				['khoi_maso' => $request->khoi, 'mh_maso' => $request->mon1],
				['khoi_maso' => $request->khoi, 'mh_maso' => $request->mon2],
				['khoi_maso' => $request->khoi, 'mh_maso' => $request->mon3],
			]);
			DB::commit();
			return array('message' => "Thêm Khối Xét Tuyển Thành Công!!!" );
		}
		catch(\Exception $e){
			
			DB::rollBack();
			return array('message' => "Thêm Khối Xét Tuyển Thất Bại!!!" );
		}
	}


	public function postThemKhoi(Request $request)
	{
		switch ($request->querry) {
			case 'insert':
				$status = $this->insertKhoi($request);
				break;
			
			case 'update':
				$status = $this->updateKhoi($request);
				break;

			case 'delete':
				$status = $this->deleteKhoi($request);
				break;

		}

		return response()->json($status);
	}

	private function deleteKhoi($request)
	{
		$maso =  $request->maso;
		try {
			DB::beginTransaction();

			DB::table('khoi')->where('khoi_maso',$maso)->delete();
           
			DB::commit();
			
			return array('message' => 'Xóa Khối Thành Công!!!','status' => true );
		} catch (\Exception $e) {
			DB::rollBack();
			return array('message' => 'Xóa Khối Thất Bại!!!','status' => false );
		}
	}

	private function updateKhoi($request)
	{
		$maso =  $request->maso;
		$ten = $request->ten;
		try {
			DB::beginTransaction();

			DB::table('khoi')->where('khoi_maso',$maso)->update(['khoi_ten' => $ten]);
           
			DB::commit();
			
			return array('message' => 'Sửa Khối Thành Công!!!','status' => true );
		} catch (\Exception $e) {
			DB::rollBack();
			return array('message' => 'Sửa Khối Thất Bại!!!','status' => false );
		}
	}

	private function insertKhoi($request)
	{
		$maso =  Uuid::generate()->string;
		$ten = $request->ten;

		try {
			DB::beginTransaction();

			DB::table('khoi')->insert(['khoi_maso'=>$maso,
										'khoi_ten'=>$ten
										]);
           
			DB::commit();
			
			return array('message' => 'Thêm Khối Thành Công!!!','status' => true );
		} catch (\Exception $e) {
			DB::rollBack();
			return array('message' => 'Thêm Khối Thất Bại!!!','status' => false );
		}
	}
	//het action khoi xet tuyen
}
