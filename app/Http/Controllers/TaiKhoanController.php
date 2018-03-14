<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Redirector;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class TaiKhoanController extends Controller
{
 	public function getDoiMatKhau()
	{
		if(Auth::check()){
    		$user = Auth::user();
    		if($user->pq_maso == 'bgd')
    			return redirect()->route('tuyensinh');
    		else
    			return redirect()->route('getLogin');
    	}
    	return View('taikhoan.doimatkhau');
	}

   

   public function getLogin()
    {
    	if(Auth::check()){
    	   return $this->redirectLogin();
    	}
    	return redirect()->route('trangchu');
    	
    }

    public function postLogin(LoginRequest $request)
    {
    	if(Auth::attempt(['user_id' => $request->user, 'password' =>  $request->pass ])){
           return $this->redirectLogin();
    	}
        session()->flash('failed', 'Đăng Nhập Thất Bại');
    	return redirect()->back();
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('trangchu');
    }

    private function redirectLogin(){
        $user = Auth::user();
            switch ($user->pq_maso) {
                case 'bgd':
                    return redirect()->route('getThongTinBoGD');
                case 'sgd':
                    return redirect()->route('getThongTinSoGD');
                case 'dh':
                    return redirect()->route('getThongTinDaiHoc');
                case 'thpt':
                    return redirect()->route('getHomeTHPTGD');
                case 'hs':
                    return redirect()->route('getThongTinHocSinh');
            }
    }

    //controller tao tai khoan bang file excel
    public function postTaoTaiKhoanExcel(Request $request)
    {
       
       $key ='';
        $status = false;
        switch (key($request->file())) {
            case 'sgd_dh':
                $arr  = $this->insertSoGDandDHExcel($request);
                $status = $arr->status;
                if ($arr->q == 'sgd') {
                    $key ='Sở Giáo Dục';
                }
                else
                {
                    $key = 'Đại Học';
                }
                break;
            case 'thpt':
                $key='Trường THPT';
                $status = $this->insertTHPTExcel($request);
                break;
            case 'hs':
                $key='Học Sinh';
                $status = $this->insertHSExcel($request);
                break;
            
        }

        if($status){
            $message = 'Thêm '.$key.' Thành Công!';
            return  response()->json(array('message' => $message,'status' => true));
        }
        else{
            $message = 'Lỗi Thêm '.$key."!";
            return  response()->json(array('message' => $message,'status' => false));
        }
        
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
                        return array('q' => $quyen,'status' => true);
                    }
                    else
                    {
                        return array('q' => $quyen,'status' => false);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    return array('q' => $quyen,'status' => false);
                }
                
            }
        
    }

    //phuong thuc them du lieu tai khoan truong thpt bang excel
    private function insertTHPTExcel($request)
    {
        //dd( $request->file('thpt')->getRealPath());
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
    //het tao tai khoan excel
}
