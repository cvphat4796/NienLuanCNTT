<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Redirector;
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
        $xx=$request->user; 
    	if(Auth::attempt(['user_id' => $request->user, 'password' =>  $request->pass ])){
           // dd($xx);
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
                   dd($user->user_id);
                case 'sdg':
                    return redirect()->route('getHomeSoGD');
                case 'dh':
                    return redirect()->route('getHomeDHGD');
                case 'thpt':
                    return redirect()->route('getHomeTHPTGD');
                case 'hs':
                    return redirect()->route('getHomeHSGD');
            }
    }
}
