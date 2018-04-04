<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TaiKhoanController extends Controller
{
 	public function postDoiMatKhau(Request $request)
	{
		if(Auth::check()){
             $user = Auth::user();
            if(Hash::check($request->mk_cu, $user->user_pass)){
                try{
                    DB::beginTransaction();

                    DB::table('users')->where('user_id', $user->user_id)
                                        ->update(['user_pass' => bcrypt($request->mk_moi)]);
                    DB::commit();
                    return array('message' => 'Đổi Mật Khẩu Thành Công', 'status' => true);
                }
                catch (\Exception $e) {
                    DB::rollBack();
                    return array('message' => 'Đổi Mật Khẩu Thất Bại', 'status' => false);
                }
            }
    	  return array('message' => 'Mật Khẩu Không Đúng', 'status' => false);
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
                    return redirect()->route('getTaiKhoanHS');
                case 'dh':
                    return redirect()->route('getNganh');
                case 'thpt':
                    return redirect()->route('getTaiKhoanHS');
                case 'hs':
                    return redirect()->route('getThongTinHocSinh');
            }
    }

    
}
