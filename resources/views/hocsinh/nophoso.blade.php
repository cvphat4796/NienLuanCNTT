@extends('layouts.hslayout')
@section('title','Nộp Hồ Sơ')
@section('content')
<script src="//cdn.datatables.net/plug-ins/1.10.16/type-detection/formatted-num.js"></script>
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

       <!-- Modal -->
      <div id="modalNopHS" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 id='h4-nophs' class="modal-title">Nộp Hồ Sơ</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <input type="hidden" value="insert" id="query">
                      <input class="form-control" id="ma-nganh"  type="hidden"/>
					           
                     <label for="">*Chọn Khối:</label>
                      <select class="form-control"  id="khoi">
                      	
                      </select>

                       <label for="">*Nhập Nguyện Vọng:</label>
                      <input type="number" class="form-control" id='nguyen-vong'/>
                 </div>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btn-themTHPT"  class="btn btn-default" onclick="submitNopHS()">Cập Nhật</button>
              </div>
          </div>
        </div>
      </div> {{-- het modal them thpt --}}

 		<table id="tableNganhHS" class="table table-bordered  table-hover table-striped">
 			<thead>
 				<tr>
 					<th>Mã Ngành</th>
 					<th>Tên Ngành</th>
			        <th>Tổ Hợp Môn Xét</th>
			        <th>Chỉ Tiêu</th>
			        <th>Điểm Chuẩn</th>
			        <th>Bậc Học</th>
              <th>NV</th>
			        <th>Trường Đại Học</th>
			       <th></th>

 				</tr>
 			</thead>
 			<tfoot>
	            <tr>
		              <td></td>
		              <td></td>
		              <td></td>
                  <td></td>
		              <td></td>
		              <td></td>
		              <td></td>
		              <td></td>
		              <td></td>
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
		

		
 	</div>
 </div>

 <script>
        $(document).ready(function () {
            $('#hs-nop').addClass('active');
        });

</script>


@endsection()


