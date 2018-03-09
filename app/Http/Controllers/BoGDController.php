<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
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
		$dss = DB::table('users')->where('pq_maso',$p)->orderBy('user_name', 'asc')->paginate(2);;
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

	//controller tao tai khoan bang file excel
	public function postTaoTaiKhoanExcel(Request $request)
	{
		$status = false;
		switch (key($request->file())) {
			case 'sgd_dh':
				$status = $this->insertSoGDandDHExcel($request);
				break;
			case 'thpt':
				$status = $this->insertTHPTExcel($request);
				break;
			case 'hs':
				$status = $this->insertHSExcel($request);
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

	//phuong thuc them du lieu tai khoan so gd va dai hoc bang excel
	private function insertSoGDandDHExcel($request)
	{
		   $path = $request->file('sgd_dh')->getRealPath();
	        $data = Excel::load($path, function($reader) {})->get();

	        if(!empty($data)){
	            foreach ($data->toArray() as $key => $value) {
	            	if(is_null($value['ma_so']))
	            		continue;
	            	$id = $value['ma_so'];
	                $ten = $value['ten'];
	                $matkhau = bcrypt($value['mat_khau']);
	                $sdt = $value['so_dien_thoai'];
	                $diachi = $value['dia_chi'];
	                $email = $value['email'];
	                $quyen= $value['quyen'];  
	                if(strtolower($quyen) == "s")
	                	$quyen = "sgd";
	                else{
	                	$quyen = "dh";
	                }
	                $insert_user[] = [
	                   'user_id' => $id, 
	                   'user_name' => $ten,
	                   'user_pass' => $matkhau,
	                   'user_addr' => $diachi,
	                   'user_phone' => $sdt,
	                   'user_email' => $email,
	                   'pq_maso' => $quyen
	                ];
	            }
	            try 
	            {

					if(!empty($insert_user))
					{
						DB::beginTransaction();

		                DB::table('users')->insert($insert_user);

						DB::commit();
		                return true;
		            }
		            else
		            {
		            	return false;
		            }
				} catch (\Exception $e) {
					DB::rollBack();
					return false;
				}
	            
	        }
	    
	}

	//phuong thuc them du lieu tai khoan truong thpt bang excel
	private function insertTHPTExcel($request)
	{
		   $path = $request->file('thpt')->getRealPath();
	        $data = Excel::load($path, function($reader) {})->get();

	        if(!empty($data)){
	            foreach ($data->toArray() as $key => $value) {
	            	if(is_null($value['ma_so']))
	            		continue;
	            	$id = strtoupper($value['ma_so']);
	                $ten = $value['ten'];
	                $matkhau = bcrypt($value['mat_khau']);
	                $sgd_maso = strtoupper($value['thuoc_sogd']);
	                $sdt = $value['so_dien_thoai'];
	                $diachi = $value['dia_chi'];
	                $email = $value['email'];
	                $quyen= "thpt";  
	                
	                $insert_user[] = [
	                   'user_id' => $id, 
	                   'user_name' => $ten,
	                   'user_pass' => $matkhau,
	                   'user_addr' => $diachi,
	                   'user_phone' => $sdt,
	                   'user_email' => $email,
	                   'pq_maso' => $quyen
	                ];
	                $insert_thpt[] = [
	                   'thpt_maso' => $id, 
	                   'sgd_maso' => $sgd_maso,
	                ];
	            }
	            try 
	            {
					if(!empty($insert_user) && !empty($insert_thpt))
					{
						DB::beginTransaction();
		                
		                DB::table('users')->insert($insert_user);

		                DB::table('thpt')->insert($insert_thpt);

						DB::commit();	
		                return true;
		            }
		            else
		            {
		            	return false;
		            }
				} catch (\Exception $e) {
					DB::rollBack();
					return false;
				}
	            
	        }
	    
	}

	//phuong thuc them du lieu tai khoan hoc sinh bang excel
	private function insertHSExcel($request)
	{
		   $path = $request->file('hs')->getRealPath();
	        $data = Excel::load($path, function($reader) {})->get();
	        
	        if(!empty($data)){
	            foreach ($data->toArray() as $key => $value) {
	            	if(is_null($value['ma_so']))
	            		continue;
	            	$id = strtoupper($value['ma_so']);
	                $ten = $value['ten'];
	                $matkhau = bcrypt($value['mat_khau']);
	                $thpt_maso = $value['thuoc_thpt'];
	                $kv = $value['khu_vuc'];
	                $sdt = $value['so_dien_thoai'];
	                $cmnd = $value['cmnd'];
	                $ngaysinh = $value['ngay_sinh'];
	                $email = $value['email'];
	                $diachi = $value['dia_chi'];
	                $gioitinh = strtolower($value['gioi_tinh'])=="nam" ? "Nam":"Nữ";

	                $quyen= "hs";  
	                
	                
	                $insert_user[] = [
	                   'user_id' => $id, 
	                   'user_name' => $ten,
	                   'user_pass' => $matkhau,
	                   'user_addr' => $diachi,
	                   'user_phone' => $sdt,
	                   'user_email' => $email,
	                   'pq_maso' => $quyen
	                ];
	                $insert_hs[] = [
	                   'hs_maso' => $id, 
	                   'thpt_maso' => $thpt_maso,
	                   'kv_maso' => $kv,
	                   'hs_cmnd' => $cmnd,
	                   'hs_ngaysinh' => $ngaysinh,
	                   'hs_gioitinh' => $gioitinh
	                ];
	            }
	            try 
	            {
					if(!empty($insert_user) && !empty($insert_hs))
					{
						DB::beginTransaction();

		                DB::table('users')->insert($insert_user);
		                
		                DB::table('hocsinh')->insert($insert_hs);

		                DB::commit();	
		                return true;
		            }
		            else
		            {
		            	return false;
		            }
				} catch (\Exception $e) {
					DB::rollBack();
					return false;
				}
	            
	        }
	    
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
		$khoi = DB::table('chitietkhoi')->join('khoi', 'chitietkhoi.khoi_maso', '=', 'khoi.khoi_maso')
							            ->join('monhoc', 'chitietkhoi.mh_maso', '=', 'monhoc.mh_maso')
							            ->select('chitietkhoi.khoi_maso', 'khoi.khoi_mota', 'monhoc.mh_ten')
							            ->get();

		$khoi=collect([
["khoi_maso" => "a", "khoi_mota" => "Khoi A", "mh_maso1" => "TO", "mh_ten1" => "Toan","mh_maso2" => "LY", "mh_ten2" => "Vat Ly", "mh_maso3" => "HO", "mh_ten3" => "Hoa Hoc"],
["khoi_maso" => "d", "khoi_mota" => "Khoi D", "mh_maso1" =>"TO", "mh_ten1" => "Toan","mh_maso2" => "HOA", "mh_ten2" => "Hoa Hoc","mh_maso3" => "Sinh", "mh_ten3" => "Hoa Hoc"]]);	
		//$khoi =  Khoi::query()->groupBy("khoi_maso");
					            
		return Datatables::of($khoi)
         
            ->make();
            // ->addColumn('action', function ($khoi) {
            //     return '<button onclick="edit(this)" data-mamon="'.$khoi->mh_maso.'" data-tenmon="'.$khoi->mh_ten.'" id="edit-'.$khoi->mh_maso.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Sửa</button> 
            //     		<button onclick="deletes(this)" data-mamon="'.$khoi->mh_maso.'" data-tenmon="'.$khoi->mh_ten.'" id="delete-'.$khoi->mh_maso.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-trash"></i> Xóa</button> ';
            // })
            // data-makhoi="'.$khoi->pluck("khoi_maso").'" data-tenkhoi="'.$khoi->pluck("khoi_maso").'" id="edit-'.$khoi->pluck("khoi_maso").'"
	}

	//controller quan ly khoi nganh
	public function getKhoiNganh()
	{
		$khoi = Khoi::all();
		foreach ($khoi as $key => $value) {
			//foreach ($value as $k => $v) {
				$i = 1;
				foreach ($value->monhocs as $monhoc) {
					
						$a[] = [
							"mh_maso".$i => $monhoc->pivot->mh_maso,
								"mh_ten".$i => $monhoc->mh_ten];
					    
					$i++;
				}
				if(is_null($a))
					continue;
				$temp = ["khoi_maso" => $value->khoi_maso, "khoi_mota" => $value->khoi_mota];
				//array_push($a, $temp);
				$b[] = $a;
				$a = null;
			//}
		}
		$khoi =  DB::table('chitietkhoi')->get()->groupBy("khoi_maso");
		//dd($khoi);
		$khoi =  Khoi::query();
		//dd($khoi);
		
		//dd($ctkh);

		$t = DB::raw("select chitietkhoi.khoi_maso, ch1.mh_maso, ch2.mh_maso, ch3.mh_maso from chitietkhoi, chitietkhoi as ch1, chitietkhoi as ch2, chitietkhoi as ch3 WHERE chitietkhoi.khoi_maso = 'A' and ch1.mh_maso != ch2.mh_maso and ch1.mh_maso != ch3.mh_maso and ch3.mh_maso != ch2.mh_maso LIMIT 1");		            
		$keys=array("0","1","2","3");
		$khoi=collect([["khoi_maso" => "a", "mh_maso1" => "TO", "mh_maso2" => "LY","mh_maso3" => "HO"],
						["khoi_maso" => "d", "mh_maso1" =>"TO","mh_maso2" => "HOA","mh_maso3" => "Sinh"]]);	
		//dd($t);
		//$a1=array_fill_keys($keys,$value);
		//dd($khoi->only("khoi_maso"));
		$monhoc = DB::table('monhoc')->get();
		
		$ctkhoi = DB::table('chitietkhoi')->select('khoi_maso')
                					->groupBy('khoi_maso')->get();

       
        foreach ($ctkhoi as $key => $value) {
        	if(!is_null($value)){

        		foreach ($value as $k => $v) {
        			$list_ma_khoi[] = $v;
        		}
        	}
        }


        foreach ($list_ma_khoi as $key => $value) {
        	
        	$list_ma_mon[] = DB::table('chitietkhoi')->select('mh_maso')->where('khoi_maso', $value)->get();
        	
	        
        }
        foreach ($list_ma_mon as $key => $value) {
	        	if(!is_null($value)){
	        		foreach ($value as $k => $v) {
	        			$list_cac_mon[] = $v->mh_maso;
	        		}
	        			
	        	}
	        }
        $b = array_fill_keys($list_ma_khoi,$list_cac_mon);
    
       
       foreach ($b as $key => $value) {
        	if(!is_null($value)){
        		
        		foreach ($value as $k => $v) {
        			
        			$a[] = $v;
        		}
        	}
        }
       
		$khoi = DB::table('khoi')
				->whereNotIn('khoi_maso', $a)->get();
		return View::make('bogds.khoinganh')
				->with(compact('khoi'))
				->with(compact('monhoc'));
	}

	 public function getMonHoc()
    {
    	//response()->json(array("message" => "Thanh Cong"));
    	$monhoc =  DB::table('monhoc')->get();
    	// return Datatables::of($monhoc)
     //        ->addColumn('action', function ($monhoc) {
     //            return '<button onclick="edit()" id="edit-'.$monhoc->mh_maso.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</button> 
     //            		<button onclick="delete()" id="delete-'.$monhoc->mh_maso.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-trash"></i> Remove</button> ';
     //        })
     //        ->make(true);
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
            DB::table('chitietkhoi')->where('khoi_maso', $ctk[0]->khoi_maso)->delete();
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
		$mon1 = $request->mon1;
		$mon2 = $request->mon2;
		$mon3 = $request->mon3;
		
		if($mon1 == $mon2 || $mon1 == $mon3 || $mon2 == $mon3){
			$status = 'Chọn trùng môn!';
			session()->flash('status', $status);
			return redirect()->back();
		} 
		DB::beginTransaction();
		try{

			DB::table('chitietkhoi')->insert([
				['khoi_maso' => $request->khoi, 'mh_maso' => $request->mon1],
				['khoi_maso' => $request->khoi, 'mh_maso' => $request->mon2],
				['khoi_maso' => $request->khoi, 'mh_maso' => $request->mon3],
			]);
			DB::commit();
			 $status = 'Thêm Khối Ngành Thành Công!';
		}
		catch(\Exception $e){
			$status = 'Lỗi Thêm! Có thể do trùng mã số';
			DB::rollBack();
		}
		session()->flash('status', $status);
		return redirect()->back();
	}

	//het khoi nganh
}
