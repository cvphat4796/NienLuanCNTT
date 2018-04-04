<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class TaiKhoanController extends Controller
{
 	public function postDoiMatKhau(Request $request)
	{
		if(Auth::check()){
             $user = Auth::user();
            if($user->user_pass == $request->pass){
                try{
                    DB::beginTransaction();

                    DB::table('users')->where('user_id', $user->user_id)
                                        ->upadte('user_pass', $request->changepass);
                    DB::commit();
                    return array('message' => 'Đổi Mật Khẩu Thành Công', 'status' => true);
                }
                catch (\Exception $e) {
                    DB::rollBack();
                    return array('message' => 'Đổi Mật Khẩu Thất Bại', 'status' => false);
                }
            }
    	   return View('taikhoan.doimatkhau');
    	}
    	return response()->json(array('message' => 'Bạn Chưa Đăng Nhập!!', 'status' => false));;
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
                    return redirect()->route('getThoiGianBoGD');
                case 'sgd':
                    return redirect()->route('getThongTinSoGD');
                case 'dh':
                    return redirect()->route('getTaiKhoanHS');
                case 'thpt':
                    return redirect()->route('getTaiKhoanHS');
                case 'hs':
                    return redirect()->route('getThongTinHocSinh');
            }
    }

    
}
