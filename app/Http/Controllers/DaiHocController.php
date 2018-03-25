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
    	
    	// $nganh =  DB::table('nganhhoc')
    	// 						->join('nganhxettuyen', 'nganhxettuyen.ngh_id', '=', 'nganhhoc.ngh_id')
    	// 						->join('khoi', 'khoi.khoi_maso', '=', 'nganhxettuyen.khoi_maso')
    	// 						->where([
    	// 								['nganhhoc.dh_maso','=',Auth::user()->user_id]])->get();
  
            
    	$khois = DB::table('khoi')->join('chitietkhoi', 'khoi.khoi_maso', '=', 'chitietkhoi.khoi_maso')
    								->select('khoi.*')
    								->distinct()
    								->get();
    	 return View::make('truongdh.danhsachnganh')
				->with(compact('khois'));
    }

    

	public function postThemNganh(Request $request)
	{

		$key = '';
		switch ($request->querry) {
			case 'insert':
				$status = $this->insertNganh($request);
				break;
			case 'update':
				$status = $this->updateNganh($request);
				break;
			case 'delete':
				$status = $this->deleteNganh($request);
				break;
		}
		return response()->json($status);
	
	}

	private function deleteNganh($request)
	{
		$nganh_id = $request->nganh_id;
		try{
			DB::beginTransaction();
				DB::table('nganhhoc')->where('ngh_id',$nganh_id)
									->delete();
			DB::commit();
			
			return array('message' => 'Xóa Ngành Thành Công!!!','status' => true);
		} catch (\Exception $e) {
			echo $e;
			DB::rollBack();
			return array('message' => 'Xóa Ngành Thất Bại!!!!','status' => false);
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
		$arrayCN = $request->cn;
		try {
			DB::beginTransaction();

			DB::table('nganhhoc')->where('ngh_id',$nganh_id)
									->update([
											'ngh_maso' => $nganh_maso,
											'ngh_ten' => $nganh_ten,
											'ngh_chitieu' => $nganh_chitieu,
											'ngh_diemchuan' => $nganh_diemchuan,
											'ngh_bachoc' => $bachoc
										]);

			DB::table('nganhxettuyen')->where('ngh_id',$nganh_id)->delete();
			$nganhxettuyen = [];
            foreach ($arrayKhoi as  $value) {
            	$nganhxettuyen[] = ['ngh_id' => $nganh_id, 'khoi_maso' => $value];
            }
            DB::table('nganhxettuyen')->insert($nganhxettuyen);

            DB::table('chuyennganh')->where('ngh_id',$nganh_id)->delete();
            if(!empty($arrayCN)){
            	$cn = [];
            	
            	foreach ($arrayCN as $value) {
            		if($value == null)
            			continue;
	            	$cn[] = ['ngh_id' => $nganh_id, 'cn_ten' => $value];
	            }
	             DB::table('chuyennganh')->insert($cn);
            }
			DB::commit();
			
			return array('message' => 'Sửa Ngành Thành Công!!!','status' => true);
		} catch (\Exception $e) {
			echo $e;
			DB::rollBack();
			return array('message' => 'Sửa Ngành Thất Bại!!!!','status' => false);
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
		$arrayCN = $request->cn;
		try {
			DB::beginTransaction();

			DB::table('nganhhoc')->insert([
											'ngh_id' => $nganh_id,
											'ngh_maso' => $nganh_maso,
											'ngh_ten' => $nganh_ten,
											'ngh_chitieu' => $nganh_chitieu,
											'ngh_diemchuan' => $nganh_diemchuan,
											'ngh_bachoc' => $bachoc,
											'dh_maso' => Auth::user()->user_id
										]);
			$nganhxt = [];
			$cn = [];
            foreach ($arrayKhoi as  $value) {
            	$nganhxt[] = ['ngh_id' => $nganh_id, 'khoi_maso' => $value];
            }
            if(!empty($arrayCN)){
            	foreach ($arrayCN as $value) {
            		if($value == null)
            			continue;
	            	$cn[] = ['ngh_id' => $nganh_id, 'cn_ten' => $value];
	            }
            }
            
            DB::table('nganhxettuyen')->insert($nganhxt);
            DB::table('chuyennganh')->insert($cn);
			DB::commit();
			
			return array('message' => 'Thêm Ngành Thành Công!!!','status' => true);
		} catch (\Exception $e) {
			echo $e;
			DB::rollBack();
			return array('message' => 'Thêm Ngành Thất Bại!!!','status' => false);
		}
	}

	public function postListHoSo(Request $request)
	{
		$id = $request->id_nganh;
		$ng = DB::table('nguyenvong')->join('nganhhoc','nganhhoc.ngh_id','nguyenvong.ngh_id')
										->join('khoi','khoi.khoi_maso','nguyenvong.khoi_maso')
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
			$hs = DB::table('users')->join('hocsinh','hocsinh.hs_maso','users.user_id')
							->join('khuvuc','khuvuc.kv_maso','hocsinh.kv_maso')->where('user_id',$value->hs_maso)->first();
			
			$v = $value;
			$v->hs_ten = $hs->user_name;
			$v->hs_sdt = $hs->user_phone;

			$v->diem_hs = $diem + $hs->kv_diemcong;
			if($diem >= $v->ngh_diemchuan ){
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
		if(SoGDController::checkTime('LTG03','giua') || SoGDController::checkTime('LTG03','cuoi')){
			$ng = DB::table('nganhhoc')
										->where('nganhhoc.ngh_id',$id)->first();
			
			return  View::make('truongdh.hoso')
					->with(compact('ng'));
		}
		return redirect()->back();
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
										'khoi_ten'=>$ten,
										'dh_maso' => Auth::user()->user_id
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
