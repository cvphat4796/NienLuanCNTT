@extends('layouts.hslayout')
@section('title','Nộp Hồ Sơ')
@section('content')


<script type="text/javascript" src="{!!asset('public/js/ajax-table-nganh-hs.js')!!}"></script>
 <div class="row">
 	<div class="col-xs-12 col-sm-12  col-md-12  col-lg-12 ">
   


      

    <!-- Modal -->
      <div id="proDialog" class="modal fade "  style="padding-top:15%; overflow-y:visible;" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-body progressDialog">
                    <div class="progress progress-striped active" style="margin-bottom:0;">
                        <div class="progress-bar" style="width: 100%">
                          Xin chờ!!!!
                        </div>
                    </div>
              </div>
            
          </div>
        </div>
      </div> {{-- het modal progress dialog --}}

 		<table id="tableNganhHS" class="table table-bordered table-hover table-striped">
 			<thead>
 				<tr>
 					<th>Mã Ngành</th>
 					<th>Tên Ngành</th>
			        <th>Tổ Hợp Môn Xét</th>
			        <th>Chỉ Tiêu</th>
			        <th>Bậc Học</th>
			        <th>Điểm Chuẩn</th>
			        <th>Trường Đại Học</th>
			        <th></th>
 				</tr>
 			</thead>
 			<tfoot>
	            <tr>
		              <td>xx</td>
		              <td>xx</td>
		              <td>xx</td>
		              <td>xxx</td>
		              <td>xxx</td>
		              <td>xxx</td>
		              <td>xxx</td>
		              <td>xxx</td>
   					</tr>
        	</tfoot>
 			<tbody>
				  	<tr>
		              <td></td>
		              <td></td>
		              <td></td>
		              <td></td>
		              <td></td>
		              <td></td>
		              <td></td>
		              <td></td>
   					</tr>
 				
 			</tbody>
 			
 		</table>
		

		<select name="form-control" id="dh" onchange="chonDH()">
			@foreach ($daihoc as $dh)
			    <option value="{{ $dh->user_id }}">{{ $dh->user_name }}</option>
			@endforeach

		</select>
 	</div>
 </div>

 <script>
        $(document).ready(function () {
            $('#hs-nop').addClass('active');
        });

</script>


@endsection()