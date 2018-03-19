<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

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
                    return redirect()->route('getHomeBoGD');
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

    
}
