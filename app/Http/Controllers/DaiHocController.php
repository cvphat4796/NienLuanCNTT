<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;
use App\Models\NganhHoc;

class DaiHocController extends Controller
{
    public function getThongTinDaiHoc()
    {
    	return View('truongdh.thongtin');
    }

    public function getNganh()
    {
    	
    	$nganh =  DB::table('nganhhoc')
    							->join('khoinganh', 'khoinganh.ngh_id', '=', 'nganhhoc.ngh_id')
    							->join('khoi', 'khoi.khoi_maso', '=', 'khoinganh.khoi_maso')
    							->where([
    									['dh_maso','=',Auth::user()->user_id]])->get();
  
            
    	$khois = DB::table('khoi')->get();
    	 return View::make('truongdh.danhsachnganh')
				->with(compact('khois'));
    }

    public function getListNganh()
	{
		
    	$nganh =  DB::table('nganhhoc')
    							->join('khoinganh', 'khoinganh.ngh_id', '=', 'nganhhoc.ngh_id')
    							->join('khoi', 'khoi.khoi_maso', '=', 'khoinganh.khoi_maso')
    							->where([
    									['dh_maso','=',Auth::user()->user_id]])->get();
    	
    	if(!$nganh->isEmpty()){
    		$id = $nganh[0]->ngh_id;
	 		 $ngh_khoi = "";
	 		// dd( $nganh->count());
	    	for($i = 0; $i < $nganh->count();$i++){
	    		if($i == ($nganh->count()-1) || $nganh[$i]->ngh_id != $id){
	    			$id = $nganh[$i]->ngh_id;
	    			$ok[] = ['ngh_maso' => $nganh[$i-1]->ngh_maso,
	    						'ngh_ten' => $nganh[$i-1]->ngh_ten,
	    						'ngh_chitieu' => $nganh[$i-1]->ngh_chitieu,
	    						'ngh_bachoc' => $nganh[$i-1]->ngh_bachoc,
	    						'ngh_khoi' => $ngh_khoi
	    					];
	    			$ngh_khoi = "";
	    		}
	    		$ngh_khoi = $ngh_khoi.'- '.$nganh[$i]->khoi_mota;
	    	}
	    	$ok = collect($ok);
    	}else{
    		$ok = collect([""]);
    	}
    	
    	return Datatables::of($ok)
                ->make();
    	
	}

	public function postThemNganh(Request $request)
	{

		$key = '';
		switch ($request->querry) {
			case 'insert':
				$key = 'Thêm';
				$status = $this->insertNganh($request);
				break;
			case 'update':
				$key = 'Sửa';
				$status = $this->updateNganh($request);
				break;
			case 'delete':
				$key = 'Xóa';
				$status = $this->deleteNganh($request);
				break;
		}


		if($status){
			$message = $key." Ngành Thành Công!!!";
			return response()->json(array('message' => $message,'status' => true));
		}
		else{
			$message = 'Lỗi '.$key;
			return response()->json(array('message' => $message,'status' => false));
		}
	}

	private function insertNganh($request)
	{
		$nganh_id = Uuid::generate()->string;
		$nganh_maso = $request->nganh_maso;
		$nganh_ten = $request->nganh_ten;
		$nganh_chitieu = $request->nganh_chitieu;
		$bachoc = $request->bh=="DH"?"Đại Học":"Cao Đẳng";

		$arrayKhoi = $request->khoi;

		try {
			DB::beginTransaction();

			DB::table('nganhhoc')->insert([
											'ngh_id' => $nganh_id,
											'ngh_maso' => $nganh_maso,
											'ngh_ten' => $nganh_ten,
											'ngh_chitieu' => $nganh_chitieu,
											'ngh_bachoc' => $bachoc,
											'dh_maso' => Auth::user()->user_id
										]);
            foreach ($arrayKhoi as  $value) {
            	$khoiNganh[] = ['ngh_id' => $nganh_id, 'khoi_maso' => $value];
            }

            DB::table('khoinganh')->insert($khoiNganh);

			DB::commit();
			
			return true;
		} catch (\Exception $e) {
			DB::rollBack();
			echo $e;
			return false;
		}
	}
}
