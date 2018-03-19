<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Redirector;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ExcelController extends Controller
{
    //controller tao tai khoan bang file excel
    public function postTaoTaiKhoanExcel(Request $request)
    {
       
        switch (key($request->file())) {
            case 'sgd_dh':
                $status  = $this->insertSoGDandDHExcel($request);
                break;
            case 'thpt':
                $status = $this->insertTHPTExcel($request);
                break;
            case 'hs':
                $status = $this->insertHSExcel($request);
                break;
            
        }

        
        return  response()->json($status);
       
        
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
                    $message = 'Thêm Sở Giáo Dục và Đại Học ';
                    if(strtolower($quyen) == "s"){
                        $quyen = "sgd";
                    }
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
                        return array('message' => $message.'Thành Công!!','status' => true);
                    }
                    else
                    {
                        return array('message' => $message.'Thất Bại!!','status' => false);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    return array('message' => $message.'Thất Bại!!','status' => false);
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
                    $message = 'Thêm Trường THPT ';
                    $insert_user[] = [
                       'user_id' => $id, 
                       'user_name' => $ten,
                       'user_pass' => $matkhau,
                       'user_addr' => $diachi,
                       'user_phone' => $sdt,
                       'user_email' => $email,
                       'sgd_maso' => $sgd_maso,
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
                        return array('message' => $message.'Thành Công!!','status' => true);
                    }
                    else
                    {
                        return array('message' => $message.'Thất Bại!!','status' => false);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    return array('message' => $message.'Thất Bại!!','status' => false);
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
                    $message = 'Thêm Học Sinh ';
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
                        return array('message' => $message.'Thành Công!!','status' => true);
                    }
                    else
                    {
                        return array('message' => $message.'Thất Bại!!','status' => false);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    return array('message' => $message.'Thất Bại!!','status' => false);
                }
                
            }
        
    }
    //het tao tai khoan excel
}
