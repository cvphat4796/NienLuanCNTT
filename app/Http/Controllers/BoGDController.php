<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;

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
	public function getTaiKhoanSoGD(){
		$sogds = DB::table('users')->where('pq_maso','sgd')->orderBy('user_name', 'asc')->paginate(3);;
		return View::make('bogds.danhsachsogd')
				->with(compact('sogds'));
	}

	//controller hien thi danh sach cac truong dai hoc
	public function getTaiKhoanDH(){
		$dhs = DB::table('users')->where('pq_maso','dh')->orderBy('user_name', 'asc')->paginate(3);
		return View::make('bogds.danhsachdh')
				->with(compact('dhs'));
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


	//controller quan ly khoi nganh
	public function getKhoiNganh()
	{
		$monhoc = DB::table('monhoc')->get();
		return View::make('bogds.khoinganh')
				->with(compact('monhoc'));
	}

}
