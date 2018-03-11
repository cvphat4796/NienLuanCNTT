<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;

class SoGDController extends Controller
{
    public function getThongTinSoGD()
    {
    	
    	return View('sogds.thongtin');
    }

	public function getListTHPT()
	{
		$thpt =  DB::table('users')
    							->join('thpt', 'users.user_id', '=', 'thpt.thpt_maso')
    							->where([
    									['pq_maso','=','thpt'],
    									['sgd_maso','=',Auth::user()->user_id]])->orderBy('user_name', 'asc')->get();
    	
    	return Datatables::of($thpt)
    	->removeColumn('user_pass')
            ->addColumn('action', function ($thpt) {
                return '<button onclick="editthpt(this)" 
                		data-mathpt="'.$thpt->user_id.'" 
                		data-tenthpt="'.$thpt->user_name.'" 
                		data-dcthpt="'.$thpt->user_addr.'"
                		data-sdtthpt="'.$thpt->user_phone.'"
                		data-emailthpt="'.$thpt->user_email.'"
                		id="editthpt-'.$thpt->user_id.'" 
                		class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Sửa</button> 
                		<button onclick="deletethpt(this)" 
                		data-mathpt="'.$thpt->user_id.'" 
                		data-tenthpt="'.$thpt->user_name.'" 
                		id="deletethpt-'.$thpt->user_id.'" 
                		class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-trash"></i> Xóa</button> ';
            })
            ->make(true);
	}		
	
    public function getTaiKhoanTHPT()
    {
    	 	return View('sogds.danhsachthpt');
    }

    public function postThemTHPT(Request $request)
    {
    	$key = '';
    	switch ($request->querry) {
    		case 'insert':
    			$key = 'Thêm';
    			$status = $this->insertTHPT($request);
    			break;
    		case 'update':
    			$key = 'Sửa';
    			$status = $this->updateTHPT($request);
    			break;
    		case 'delete':
    			$key = 'Xóa';
    			$status = $this->deleteTHPT($request);
    			break;
    	}

    	if($status){
			$message = $key.' Trường THPT Thành Công!';
			return	response()->json(array('message' => $message,'status' => true));
		}
		else{
			$message = 'Lỗi '.$key."!";
			return	response()->json(array('message' => $message,'status' => false));
		}
    }

    private function deleteTHPT($request)
    {
    	$thpt_maso = $request->thpt_maso;
    	try {
			DB::beginTransaction();

			DB::table('users')->where('user_id', strtoupper($thpt_maso))->delete();
            
			DB::commit();
			
			return true;
		} catch (\Exception $e) {
			DB::rollBack();
			return false;
		}
    }

    private function updateTHPT($request)
    {
    	$thpt_maso = $request->thpt_maso;
    	$thpt_ten = $request->thpt_ten;
    	$thpt_diachi = $request->thpt_diachi;
    	$thpt_sdt = $request->thpt_sdt;
    	$thpt_email = $request->thpt_email;

    	try {
			DB::beginTransaction();

			DB::table('users')->where('user_id', strtoupper($thpt_maso))
            					->update([	'user_addr' => $thpt_diachi,
									    	'user_phone' => $thpt_sdt,
									    	'user_email' => $thpt_email,
									    	'user_name' => $thpt_ten
									   	]);
            
			DB::commit();
			
			return true;
		} catch (\Exception $e) {
			DB::rollBack();
			return false;
		}
    }

    private function insertTHPT($request)
    {
    	$thpt_maso = $request->thpt_maso;
    	$thpt_ten = $request->thpt_ten;
    	$thpt_pass = bcrypt($request->thpt_pass);
    	$thpt_diachi = $request->thpt_diachi;
    	$thpt_sdt = $request->thpt_sdt;
    	$thpt_email = $request->thpt_email;

    	try {
			DB::beginTransaction();

			DB::table('users')->insert(
			 	[	'user_id' => strtoupper($thpt_maso), 
			    	'user_pass' => $thpt_pass,
			    	'user_addr' => $thpt_diachi,
			    	'user_phone' => $thpt_sdt,
			    	'user_email' => $thpt_email,
			    	'pq_maso' => 'thpt',
			    	'user_name' => $thpt_ten
			   	]);

			DB::table('thpt')->insert(
				[	'thpt_maso' => strtoupper($thpt_maso),
					'sgd_maso' => Auth::user()->user_id
				]);
			DB::commit();
			
			return true;
		} catch (\Exception $e) {
			DB::rollBack();
			return false;
		}

    }

    //action hien thi trang sanh sach hoc sinh
    public function getTaiKhoanHS()
    {
    	$thpts = DB::table('users')
    							->join('thpt', 'users.user_id', '=', 'thpt.thpt_maso')
    							->where([
    									['pq_maso','=','thpt'],
    									['sgd_maso','=',Auth::user()->user_id]])->orderBy('user_name', 'asc')->get();
    	$khuvucs = DB::table('khuvuc')->get();
		 return View::make('sogds.danhsachhocsinh')
				->with(compact('thpts'))
				->with(compact('khuvucs'));
    }

    public function getListHS()
	{
		//SELECT * FROM users JOIN hocsinh ON hocsinh.hs_maso = users.user_id WHERE hocsinh.thpt_maso in (SELECT users.user_id from users JOIN thpt on thpt.thpt_maso = users.user_id WHERE thpt.sgd_maso='SGDKG')
		
		$thpt =  DB::table('users')
    							->join('thpt', 'users.user_id', '=', 'thpt.thpt_maso')
    							->select('user_id')
    							->where([
    									['pq_maso','=','thpt'],
    									['sgd_maso','=',Auth::user()->user_id]])->orderBy('user_name', 'asc')->get()->toArray();
    	$thpt = array_map(function($object){
				    return (array) $object;
				}, $thpt);

		$hs =  DB::table('hocsinh')
    							->join('users', 'users.user_id', '=', 'hocsinh.hs_maso')
    							->join('khuvuc', 'khuvuc.kv_maso', '=', 'hocsinh.kv_maso')
    							->join('users as thpt', 'thpt.user_id', '=', 'hocsinh.thpt_maso')
    							->select('hocsinh.*','users.*','khuvuc.*','thpt.user_name as thpt_ten')
    							->whereIn('hocsinh.thpt_maso',$thpt)->get();

    	return Datatables::of($hs)
    	->removeColumn('user_pass')
    	->removeColumn('kv_diemcong')
    	->removeColumn('hs_maso')
            ->addColumn('action', function ($hs) {
                return '<button onclick="ediths(this)" 
                		data-mahs="'.$hs->user_id.'" 
                		data-tenhs="'.$hs->user_name.'" 
                		data-dchs="'.$hs->user_addr.'"
                		data-sdths="'.$hs->user_phone.'"
                		data-ngaysinh="'.$hs->hs_ngaysinh.'"
                		data-gioitinh="'.$hs->hs_gioitinh.'"
                		data-cmnd="'.$hs->hs_cmnd.'"
                		data-kvms="'.$hs->kv_maso.'"
                		data-thpt="'.$hs->thpt_maso.'"
                		data-emailhs="'.$hs->user_email.'"
                		id="ediths-'.$hs->user_id.'" 
                		class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Sửa</button> 
                		<button onclick="deletehs(this)" 
                		data-mahs="'.$hs->user_id.'" 
                		data-tenhs="'.$hs->user_name.'" 
                		id="deletehs-'.$hs->user_id.'" 
                		class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-trash"></i> Xóa</button> ';
            })
            ->make(true);
	}	

    public function postThemHS(Request $request)
    {
    	$key = '';
    	switch ($request->querry) {
    		case 'insert':
    			$key = 'Thêm';
    			$status = $this->insertHS($request);
    			break;
    		case 'update':
    			$key = 'Sửa';
    			$status = $this->updateHS($request);
    			break;
    		case 'delete':
    			$key = 'Xóa';
    			$status = $this->deleteHS($request);
    			break;
    	}

    	if($status){
			$message = $key.' Học Sinh Thành Công!';
			return	response()->json(array('message' => $message,'status' => true));
		}
		else{
			$message = 'Lỗi '.$key."!";
			return	response()->json(array('message' => $message,'status' => false));
		}
    }

    private function deleteHS($request)
    {
    	$hs_maso = $request->hs_maso;
    	try {
			DB::beginTransaction();

			DB::table('users')->where('user_id', strtoupper($hs_maso))->delete();
            
			DB::commit();
			
			return true;
		} catch (\Exception $e) {
			DB::rollBack();
			return false;
		}
    }

    private function updateHS($request)
    {
    	$hs_maso = $request->hs_maso;
  		$hs_ten = $request->hs_ten;
    	$hs_diachi = $request->hs_diachi;
    	$hs_sdt = $request->hs_sdt;
    	$hs_email = $request->hs_email;

    	$hs_cmnd = $request->hs_cmnd;
    	$hs_ngaysinh = date("Y-m-d", strtotime(str_replace('/', '-',$request->hs_ngaysinh)) );
    	$hs_gioitinh = $request->hs_gioitinh=="Nam"?"Nam":"Nữ";
    	$hs_kv = $request->hs_kv;
    	$hs_thpt = $request->hs_thpt;
    	try {
			DB::beginTransaction();

			DB::table('users')->where('user_id', strtoupper($hs_maso))
            					->update([	'user_addr' => $hs_diachi,
									    	'user_phone' => $hs_sdt,
									    	'user_email' => $hs_email,
									    	'user_name' => $hs_ten
									   	]);
            
            DB::table('hocsinh')->where('hs_maso', strtoupper($hs_maso))
            					->update([	'thpt_maso' => $hs_thpt,
									    	'hs_cmnd' => $hs_cmnd,
									    	'hs_ngaysinh' => $hs_ngaysinh,
									    	'hs_gioitinh' => $hs_gioitinh,
									    	'kv_maso' => $hs_kv
									   	]);

			DB::commit();
			
			return true;
		} catch (\Exception $e) {
			DB::rollBack();
			return false;
		}
    }

    private function insertHS($request)
    {
    	$hs_maso = $request->hs_maso;
    	$hs_ten = $request->hs_ten;
    	$hs_pass = bcrypt($request->hs_pass);
    	$hs_diachi = $request->hs_diachi;
    	$hs_sdt = $request->hs_sdt;
    	$hs_email = $request->hs_email;

    	$hs_cmnd = $request->hs_cmnd;

    	$hs_ngaysinh = date("Y-m-d", strtotime(str_replace('/', '-',$request->hs_ngaysinh)) );
    	$hs_gioitinh = $request->hs_gioitinh=="Nam"?"Nam":"Nữ";
    	$hs_kv = $request->hs_kv;
    	$hs_thpt = $request->hs_thpt;
    	try {
			DB::beginTransaction();

			DB::table('users')->insert(
			 	[	'user_id' => strtoupper($hs_maso), 
			    	'user_pass' => $hs_pass,
			    	'user_addr' => $hs_diachi,
			    	'user_phone' => $hs_sdt,
			    	'user_email' => $hs_email,
			    	'pq_maso' => 'hs',
			    	'user_name' => $hs_ten
			   	]);

			DB::table('hocsinh')->insert([	'hs_maso' => strtoupper($hs_maso),
            								'thpt_maso' => $hs_thpt,
									    	'hs_cmnd' => $hs_cmnd,
									    	'hs_ngaysinh' => $hs_ngaysinh,
									    	'hs_gioitinh' => $hs_gioitinh,
									    	'kv_maso' => $hs_kv
									   	]);
			
			DB::commit();
			
			return true;
		} catch (\Exception $e) {
			DB::rollBack();
			return false;
		}

    }

}
