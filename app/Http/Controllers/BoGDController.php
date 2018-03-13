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
	//controller trang chu bo giao duc
	public function getHomeBoGD()
	{
		$thoigians = DB::table('thoigian')
					->join('users', 'thoigian.user_id', '=', 'users.user_id')
					->select('users.user_name', 'thoigian.*')
					->get();
		 return View::make('bogds.trangchu')
				->with(compact('thoigians'));
	}

	public function getThongTinBoGD()
	{
		return view('bogds.thongtin');
	}

	public function postThoiGian1(Request $request)
	{
		//dd("xxx");
		dd($request);
	}

	public function postThoiGian(Request $request)
	{
		$tg_maso = Uuid::generate()->string;
		$user_id = Auth::user()->user_id;
		//dd(strtotime("2011-01-01")$request->datebegin);
		$tg_batdau = date('Y-m-d', strtotime(str_replace('/', '-', $request->datebegin)));
		$tg_ketthuc = date('Y-m-d', strtotime(str_replace('/', '-', $request->dateend)));
		$tg_mota = $request->mota;
		$status = "";
		
		try 
		{  
			DB::table('thoigian')->insert(['tg_maso' => $tg_maso,
											'user_id' => $user_id,
											'tg_batdau' => $tg_batdau,
											'tg_ketthuc' => $tg_ketthuc,
											'tg_mota' => $tg_mota
											]);
		    $status = "Thêm tài khoản thành công!";
		} 
		catch (Exception $e) 
		{
			$status = "Thêm tài khoản thất bại!";
			
		}
		session()->flash('status', $status);
		return redirect()->back();
	}

	//controller hien thi danh sach cac so giao duc
	public function getTaiKhoanSoGDDH($p){
		$dss = DB::table('users')->where('pq_maso',$p)->orderBy('user_name', 'asc')->paginate(2);
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
				->with(compact('title'))
				->with(compact('dss'));
	}

	

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
			    	'user_name' => $request->ten
			   	]);

			DB::table('thpt')->insert(
				[	'thpt_maso' => strtoupper($request->maso),
					'sgd_maso' => $request->sogd
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
		foreach ($khoi as $key => $value) {
				$i = 1;
				$arrayMH = [];
				foreach ($value->monhocs as $monhoc) {
						$arrayMH = [
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
	        $list_ma_khoi[];
	        foreach ($ctkhoi as $k => $v) {
	        	$list_ma_khoi = $v->khoi_maso;

	        }

	        $khoi = DB::table('khoi')->whereNotIn('khoi_maso', $list_ma_khoi)->get();
		}
		else{
			$khoi = DB::table('khoi')->get();
		}
		
        $mon = DB::table('monhoc')->orderBy('mh_ten','asc')->get();
		return	response()->json(array('listKhoi' => $khoi, 'listMon' => $mon));
	}

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

	public function postMonHoc(Request $request)
	{
		$key = "";
		switch ($request->querry) {
			case 'insert':
				$key = 'Thêm';
				$status = $this->insertMH($request);
				break;
			case 'update':
				$key = 'Sửa';
				$status = $this->updateMH($request);
				break;
			case 'delete':
				$key = 'Xóa';
				$status = $this->deleteMH($request);
				break;
			default:
				return redirect()->back();
				break;
		}
		
		if($status){
			$message = $key.' Mô Học Thành Công!';
			return	response()->json(array('message' => $message));
		}
		else{
			$message = 'Lỗi '.$key."!";
			return	response()->json(array('message' => $message));
		}
		//return redirect()->back();
	}

	private function insertMH($request)
	{
		DB::beginTransaction();
		try{
			DB::table('monhoc')->insert(
				[ 'mh_maso' => $request->mh_maso,
					'mh_ten' => $request->mh_ten
				]);
			DB::commit();

			return $status = true; //'Thêm Mô Học Thành Công!';
		}
		catch(\Exception $e){
			
			DB::rollBack();
			return $status = false; //'Lỗi Thêm! Có thể do trùng mã số';
		}
	}

	private function updateMH($request)
	{
		DB::beginTransaction();

		try{
			DB::table('monhoc')->where('mh_maso', $request->mh_maso)
            					->update(['mh_ten' => $request->mh_ten]);
            
			DB::commit();
			return $status = true; //'Thêm Mô Học Thành Công!';
		}
		catch(\Exception $e){
			
			DB::rollBack();
			return $status = false; //'Lỗi Thêm! Có thể do trùng mã số';
		}
	}

	private function deleteMH($request)
	{
		DB::beginTransaction();
		try{
			$ctk = DB::table('chitietkhoi')->where('mh_maso', $request->mh_maso)->get();
            DB::table('monhoc')->where('mh_maso', $request->mh_maso)->delete();
            if(!$ctk->isEmpty())
            {
            	DB::table('chitietkhoi')->where('khoi_maso', $ctk[0]->khoi_maso)->delete();
            }
			DB::commit();
			return $status = true; //'Thêm Mô Học Thành Công!';
		}
		catch(\Exception $e){
			
			DB::rollBack();
			return $status = false; //'Lỗi Thêm! Có thể do trùng mã số';
		}
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
