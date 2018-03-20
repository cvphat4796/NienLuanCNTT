<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use App\Models\MonHoc;
use App\Models\Khoi;

class BoGDController extends Controller
{
	
	public function getThoiGianBoGD()
	{
		
		$ltg = DB::table('loaithoigian')->get();
		
		 return View::make('bogds.trangchu')->with(compact('ltg'));
	}

	
	//action xu ly thoi gian
	public function postThoiGian(Request $request)
	{
		$status = [];
		switch ($request->querry) {
			case 'insert':
				$status = $this->insertThoiGian($request);
				break;
			case 'update':
				$status = $this->upadteThoiGian($request);
				break;
			case 'delete':
				$status = $this->deleteThoiGian($request);
				break;
		}

		return response()->json($status);
	}

	private function deleteThoiGian($request)
	{
		$ltg = $request->ltg;
		try{
			DB::beginTransaction();

			DB::table('thoigian')->where('ltg_maso',$ltg)->delete();
			DB::commit();
			return array('message' => 'Xóa Thời Gian Thành Công', 'status' => true);
		}
		catch (\Exception $e) {
			DB::rollBack();
			return array('message' => 'Xóa Thời Gian Thất Bại', 'status' => false);
		}
	}

	private function upadteThoiGian($request)
	{
		$ltg = $request->ltg;
		$datebegin = date("Y-m-d", strtotime(str_replace('/', '-',$request->ngaybd)));
		$dateend = date("Y-m-d", strtotime(str_replace('/', '-',$request->ngaykt)));
		try{
			DB::beginTransaction();

			DB::table('thoigian')->where('ltg_maso',$ltg)->update(['tg_batdau'=>$datebegin, 'tg_ketthuc' => $dateend]);
			DB::commit();
			return array('message' => 'Sửa Thời Gian Thành Công', 'status' => true);
		}
		catch (\Exception $e) {
			DB::rollBack();
			return array('message' => 'Sửa Thời Gian Thất Bại', 'status' => false);
		}
	}

	private function insertThoiGian($request)
	{
		$ltg = $request->ltg;
		$datebegin = date("Y-m-d", strtotime(str_replace('/', '-',$request->ngaybd)));
		$dateend = date("Y-m-d", strtotime(str_replace('/', '-',$request->ngaykt)));

		try{
			DB::beginTransaction();

			DB::table('thoigian')->insert(
			 	[	'bgd_maso' => Auth::user()->user_id, 
			    	'ltg_maso' => $ltg,
			    	'tg_batdau' => $datebegin,
			    	'tg_ketthuc' => $dateend
			   	]);
			DB::commit();
			return array('message' => 'Thêm Thời Gian Thành Công', 'status' => true);
		}
		catch (\Exception $e) {
			DB::rollBack();
			return array('message' => 'Thêm Thời Gian Thất Bại', 'status' => false);
		}
	}
	//het action xu ly thoi gian

	//action lay du lieu thoi gian
	public function getListThoiGianBoGD()
	{
		$thoigian = DB::table('thoigian')
					->join('loaithoigian','loaithoigian.ltg_maso','thoigian.ltg_maso')
					->get();
		
		 return Datatables::of($thoigian)->make();
	}

	public function getListLoaiThoiGianBoGD()
	{
		$loaithoigian = DB::table('loaithoigian')->get();
		 return Datatables::of($loaithoigian)->make(true);
	}
	// het action lay du lieu  thoi gian

	//controller trang chu bo giao duc
	public function getHomeBoGD()
	{
		return view('bogds.thongtin');
	}


	//action danh sach cac so giao duc dai hoc
	public function getTaiKhoanSoGDDH($p){
		
		$title = "";
		switch ($p) {
			case 'sgd':
				$title = "Danh Sách Sở Giáo Dục";
				break;
			case 'dh':
				$title = "Danh Sách Sở Trường Đại Học";
				break;
			default:
				return View('errors.404');
		}
		return View::make('bogds.danhsachsogdvadh')
				->with(compact('title'));
	}

	public function postSuaThongTinSGDDH(Request $request)
	{
		switch ($request->querry) {
			case 'update':
				$status = $this->upadteSGDDH($request);
				break;
			
			case 'delete':
				$status = $this->deleteSGDDH($request);
				break;
		}

		return response()->json($status);
	}

	private function deleteSGDDH($request)
	{
		$maso = $request->ma_so;
		try{
			DB::beginTransaction();
			DB::table('users')->where('user_id',$maso)->delete();
			DB::commit();
			return array('message' => 'Xóa Thành Công', 'status' => true);
		}
		catch (\Exception $e) {
			DB::rollBack();
			return array('message' => 'Xóa Thất Bại', 'status' => false);
		}
	}

	private function upadteSGDDH($request)
	{
		$maso = $request->ma_so;
		$ten = $request->ten;
		$diachi = $request->dia_chi;
		$sdt = $request->sdt;
		$email = $request->email;
		try{
			DB::beginTransaction();
			
			DB::table('users')->where('user_id',$maso)->update(['user_name'=>$ten,
																'user_addr' => $diachi,
																'user_phone' =>$sdt,
																'user_email' =>$email,
																]);
			DB::commit();
			return array('message' => 'Sửa Thành Công', 'status' => true);
		}
		catch (\Exception $e) {
			DB::rollBack();
			return array('message' => 'Sửa Thất Bại', 'status' => false);
		}
	}

	public function postListSGDDH(Request $request)
	{
		$key = $request->key;
		$dss = DB::table('users')->where('pq_maso',$key)->orderBy('user_name', 'asc')->get();
		return Datatables::of($dss)->removeColumn('user_pass')->make();
	}
	//het action danh sach so giao duc dai hoc

	//controller trang tao tai khoan
    public function getTaoTaiKhoan($status="")
	{
		$data = DB::table('phanquyen')->orderBy('pq_mota', 'asc')->get();
		$sogds = DB::table('users')->where('pq_maso','sgd')->orderBy('user_name', 'asc')->get();
		$thpts = DB::table('users')->where('pq_maso','thpt')->orderBy('user_name', 'asc')->get();
		$khuvucs = DB::table('khuvuc')->orderBy('kv_ten', 'asc')->get();		
		return View::make('bogds.taotaikhoan')
				->with(compact('data'))
				->with(compact('sogds'))
				->with(compact('thpts'))
				->with(compact('khuvucs'));
	}

	

	//post controller tao tai khoan
	public function postTaoTaiKhoan(Request $request)
	{
		$status = false;
		switch ($request->quyen) {
			case 'sgd':
				$status = $this->insertSoGDandDH($request);
				break;
			case 'dh':
				$status = $this->insertSoGDandDH($request);
				break;
			case 'thpt':
				$status = $this->insertTHPT($request);
				break;
			case 'hs':
				$status = $this->insertHS($request);
				break;
				
		}
		
		if ($status) {
			$status = "Thêm tài khoản thành công!";
		}else{
			$status = "Thêm tài khoản thất bại!";

		}
		
		session()->flash('status', $status);
		return redirect()->back();
	}

	//phuong thuc them du lieu tai khoan so gd va dai hoc 
	private function insertSoGDandDH($request)
	{
		try {
			DB::beginTransaction();

			DB::table('users')->insert(
			 	[	'user_id' => strtoupper($request->maso), 
			    	'user_pass' => bcrypt($request->matkhau),
			    	'user_addr' => $request->diachi,
			    	'user_phone' => $request->sdt,
			    	'user_email' => $request->email,
			    	'pq_maso' => $request->quyen,
			    	'user_name' => $request->ten
			   	]);
			DB::commit();
			
			return true;
		} catch (\Exception $e) {
			DB::rollBack();
			return false;
		}
	}

	//phuong thuc them du lieu tai khoan thpt
	private function insertTHPT($request)
	{
		try {
			DB::beginTransaction();
			
			DB::table('users')->insert(
			 	[	'user_id' => strtoupper($request->maso), 
			    	'user_pass' => bcrypt($request->matkhau),
			    	'user_addr' => $request->diachi,
			    	'user_phone' => $request->sdt,
			    	'user_email' => $request->email,
			    	'pq_maso' => $request->quyen,
			    	'sgd_maso' => $request->sogd,
			    	'user_name' => $request->ten
			   	]);


			DB::commit();
			return true;
		} catch (\Exception $e) {
			DB::rollBack();
			return false;
		}
	}

	//phuong thuc them du lieu tai khoan hoc sinh
	private function insertHS($request)
	{
		try {
			DB::beginTransaction();
			
			DB::table('users')->insert(
			 	[	'user_id' => strtoupper($request->maso), 
			    	'user_pass' => bcrypt($request->matkhau),
			    	'user_addr' => $request->diachi,
			    	'user_phone' => $request->sdt,
			    	'user_email' => $request->email,
			    	'pq_maso' => $request->quyen,
			    	'user_name' => $request->ten
			   	]);

			DB::table('hocsinh')->insert(
				[	'hs_maso' => strtoupper($request->maso),
					'thpt_maso' => $request->thpt,
					'hs_cmnd' => $request->cmnd,
					'hs_ngaysinh' => $request->ngaysinh,
					'hs_gioitinh' => $request->gioitinh,
					'kv_maso' => $request->kv_maso
				]);

			DB::commit();
			return true;
		} catch (\Exception $e) {
			DB::rollBack();
			return false;
		}
	}
	//het tao tai khoan

	//action table hoc sinh

	public function getHocSinh()
	{
		$dsthpt = DB::table('users')->where('pq_maso','thpt')->get();
		$dskv = DB::table('khuvuc')->get();
		return View::make('bogds.danhsachhs')->with(compact('dsthpt'))
											->with(compact('dskv'));
	}

	public function getListHocSinh()
	{
		$hs =  DB::table('hocsinh')->join('users as thpt', 'thpt.user_id', '=', 'hocsinh.thpt_maso')
								->join('users', 'users.user_id', '=', 'hocsinh.hs_maso')
                                ->select('users.*','hocsinh.*','thpt.user_name as ten_thpt','thpt.user_id as id_thpt')
    							->orderBy('user_name', 'asc')->get();
    		
    	return Datatables::of($hs)
    	->removeColumn('user_pass')
            ->addColumn('action', function ($hs) {
                return '<button onclick="ediths(this)" 
                		data-mahs="'.$hs->hs_maso.'" 
                		data-tenhs="'.$hs->user_name.'" 
                		data-dchs="'.$hs->user_addr.'"
                		data-sdths="'.$hs->user_phone.'"
                		data-ngaysinh="'.$hs->hs_ngaysinh.'"
                		data-gioitinh="'.$hs->hs_gioitinh.'"
                		data-cmnd="'.$hs->hs_cmnd.'"
                		data-kvms="'.$hs->kv_maso.'"
                		data-emailhs="'.$hs->user_email.'"
                		data-tenthpt="'.$hs->ten_thpt.'"
                		data-idthpt="'.$hs->id_thpt.'"
                		id="ediths-'.$hs->hs_maso.'" 
                		class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Sửa</button> 

                		<button onclick="deletehs(this)" 
                		data-mathpt="'.$hs->hs_maso.'" 
                		data-tenthpt="'.$hs->user_name.'" 
                		id="deletehs-'.$hs->hs_maso.'" 
                		class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Xóa</button>
                        ';

            })
            ->make(true);
	}
	//het action table hoc sinh

	public function getListKhoiNganh()
	{
		$khoi = Khoi::all();
		//mang muon [	'khoi_maso' => value, 
		//				'khoi_mota' => value, 
		//				'mon1_maso' => value,
		//				'mon1_ten' => value,
		//				'mon2_maso' => value,
		//				'mon2_ten' => value,
		//				'mon3_maso' => value,
		//				'mon3_ten' => value ] cau truc array can tra ve
		// for lay array cac mon hoc va khoi
		$arrayMH = array();
		$arrayKhoiMH = array();
		$okMH = array();
		$ok = array();
		foreach ($khoi as $key => $value) {
				$i = 1;
				
				if(($value->monhocs)->isEmpty())
					continue;
				foreach ($value->monhocs as $monhoc) {
						$arrayMH[] = [
							"mh_maso".$i => $monhoc->pivot->mh_maso,
							"mh_ten".$i => $monhoc->mh_ten];
					$i++;
				}
				if(is_null($arrayMH))
					continue;
				$temp = ["khoi_maso" => $value->khoi_maso, "khoi_mota" => $value->khoi_mota];
				array_push($arrayMH, $temp);
				$arrayKhoiMH[] = $arrayMH;
				$arrayMH = null;
		}

		//for lay mang theo cau truc 
		foreach ($arrayKhoiMH as $key => $value) {
			for($i = 0; $i < count($value); $i++){
				foreach ($value[$i] as $k => $v) {
					$okMH[$k] = $v;
				}
			}
			$ok[]=$okMH;
		}

		$khoi = collect($ok);
					            
		return Datatables::of($khoi)->make();
           
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
		
        $mon = DB::table('monhoc')->orderBy('mh_ten','asc')->get();
		return	response()->json(array('listKhoi' => $khoi, 'listMon' => $mon));
	}

	//action list thpt

	public function getListTHPT()
	{
		$thpt =  DB::table('users')->join('users as sgd', 'sgd.user_id', '=', 'users.sgd_maso')
                                ->select('users.*','sgd.user_name as ten_sgd','sgd.user_id as id_sgd')
    							->where(
    									'users.pq_maso','=','thpt')->orderBy('user_name', 'asc')->get();
    	
    	return Datatables::of($thpt)
    	->removeColumn('user_pass')
            ->addColumn('action', function ($thpt) {
                return '<button onclick="editthpt(this)" 
                		data-mathpt="'.$thpt->user_id.'" 
                		data-tenthpt="'.$thpt->user_name.'" 
                		data-dcthpt="'.$thpt->user_addr.'"
                		data-sdtthpt="'.$thpt->user_phone.'"
                		data-emailthpt="'.$thpt->user_email.'"
                		data-tensgd="'.$thpt->ten_sgd.'"
                		data-idsgd="'.$thpt->id_sgd.'"
                		id="editthpt-'.$thpt->user_id.'" 
                		class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Sửa</button> 

                		<button onclick="deletethpt(this)" 
                		data-mathpt="'.$thpt->user_id.'" 
                		data-tenthpt="'.$thpt->user_name.'" 
                		id="deletethpt-'.$thpt->user_id.'" 
                		class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Xóa</button>
                        ';

            })
            ->make(true);
	}

	public function getTHPT()
	{
		$sgds = DB::table('users')->where('pq_maso','sgd')->get();
		return View::make('bogds.danhsachthpt')->with(compact('sgds'));
	}
	//het action thpt

	//controller quan ly khoi nganh
	public function getKhoiNganh()
	{
		return View('bogds.khoinganh');
	}

	 public function getMonHoc()
    {
    	//response()->json(array("message" => "Thanh Cong"));
    	$monhoc =  DB::table('monhoc')->get();
    	
    	return Datatables::of($monhoc)
            ->addColumn('action', function ($monhoc) {
                return '<button onclick="edit(this)" data-mamon="'.$monhoc->mh_maso.'" data-tenmon="'.$monhoc->mh_ten.'" id="edit-'.$monhoc->mh_maso.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Sửa</button> 
                		<button onclick="deletes(this)" data-mamon="'.$monhoc->mh_maso.'" data-tenmon="'.$monhoc->mh_ten.'" id="delete-'.$monhoc->mh_maso.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-trash"></i> Xóa</button> ';
            })
            ->rawColumns([1, 2])
            ->make();
    }

	

	public function getKhoi()
    {
    	
    	$khoi =  DB::table('khoi')->get();
    	
    	  return Datatables::of($khoi)
            ->addColumn('action', function ($khoi) {
                return '<button onclick="editKhoi(this)" data-makhoi="'.$khoi->khoi_maso.'" data-tenkhoi="'.$khoi->khoi_mota.'" id="edit-'.$khoi->khoi_maso.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Sửa</button> 
                		<button onclick="deleteKhoi(this)" data-makhoi="'.$khoi->khoi_maso.'" data-tenkhoi="'.$khoi->khoi_mota.'" id="delete-'.$khoi->khoi_maso.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-trash"></i> Xóa</button> ';
            })
            ->rawColumns([1, 2])
            ->make();
    }

	public function postKhoi(Request $request)
	{
		$key = "";
		switch ($request->querry) {
			case 'insert':
				$key = 'Thêm';
				$status = $this->insertKhoi($request);
				break;
			case 'update':
				$key = 'Sửa';
				$status = $this->updateKhoi($request);
				break;
			case 'delete':
				$key = 'Xóa';
				$status = $this->deleteKhoi($request);
				break;
			default:
				return redirect()->back();
				break;
		}
		
		if($status){
			$message = $key.' Khối Thành Công!';
			return	response()->json(array('message' => $message));
		}
		else{
			$message = 'Lỗi '.$key." Khối!";
			return	response()->json(array('message' => $message));
		}
		
	}

	private function insertKhoi($request)
	{
		DB::beginTransaction();
		try{
			DB::table('khoi')->insert(
				[ 'khoi_maso' => strtoupper($request->khoi_maso),
					'khoi_mota' => $request->khoi_ten
				]);
			DB::commit();
			return $status = true;
		}
		catch(\Exception $e){
			DB::rollBack();
			return	$status = false;
			
		}
	}

	private function updateKhoi($request)
	{
		DB::beginTransaction();

		try{
			DB::table('khoi')->where('khoi_maso', $request->khoi_maso)
            					->update(['khoi_mota' => $request->khoi_ten]);
            
			DB::commit();
			return $status = true; //'Thêm Mô Học Thành Công!';
		}
		catch(\Exception $e){
			
			DB::rollBack();
			return $status = false; //'Lỗi Thêm! Có thể do trùng mã số';
		}
	}

	private function deleteKhoi($request)
	{
		DB::beginTransaction();

		try{
			
            DB::table('chitietkhoi')->where('khoi_maso', $request->khoi_maso)->delete();
            DB::table('khoi')->where('khoi_maso', $request->khoi_maso)->delete();
			DB::commit();
			return $status = true; //'Thêm Mô Học Thành Công!';
		}
		catch(\Exception $e){
			
			DB::rollBack();
			return $status = false; //'Lỗi Thêm! Có thể do trùng mã số';
		}
	}

	public function postKhoiNganh(Request $request)
	{
		$key = "";
		switch ($request->querry) {
			case 'insert':
				$key = 'Thêm';
				$status = $this->insertKhoiNganh($request);
				break;
			case 'update':
				$key = 'Sửa';
				$status = $this->updateKhoiNganh($request);
				break;
			case 'delete':
				$key = 'Xóa';
				$status = $this->deleteKhoiNganh($request);
				break;
			default:
				return redirect()->back();
				break;
		}
		
		if($status){
			$message = $key.' Tổ Hợp Môn Thành Công!';
			return	response()->json(array('message' => $message));
		}
		else{
			$message = 'Lỗi '.$key." Tổ Hợp Môn!";
			return	response()->json(array('message' => $message));
		}

		
	}

	private function deleteKhoiNganh($request)
	{
		DB::beginTransaction();
		try{
			DB::table('chitietkhoi')->where('khoi_maso', $request->khoi)->delete();
			DB::commit();
			return true;
		}
		catch(\Exception $e){
			
			DB::rollBack();
			return false;
		}
	}

	private function updateKhoiNganh($request)
	{
		$mon1 = $request->mon1;
		$mon2 = $request->mon2;
		$mon3 = $request->mon3;		
		DB::beginTransaction();
		try{
			DB::table('chitietkhoi')->where('khoi_maso', $request->khoi)->delete();
			DB::table('chitietkhoi')->insert([
				['khoi_maso' => $request->khoi, 'mh_maso' => $request->mon1],
				['khoi_maso' => $request->khoi, 'mh_maso' => $request->mon2],
				['khoi_maso' => $request->khoi, 'mh_maso' => $request->mon3],
			]);
			DB::commit();
			return true;
		}
		catch(\Exception $e){
			
			DB::rollBack();
			return false;
		}
	}

	private function insertKhoiNganh($request)
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
			return true;
		}
		catch(\Exception $e){
			
			DB::rollBack();
			return false;
		}
	}

	//het khoi nganh
}
