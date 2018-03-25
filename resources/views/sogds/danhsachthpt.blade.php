@extends('layouts.sgdlayout')
@section('title','Danh Sách Các Trương THPT')
@section('content')
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="{!!asset('public/js/sogds/ajax-table-thpt.js')!!}"></script>

 <div class="row">
 	<div class="col-xs-12 col-sm-12  col-md-12  col-lg-12 ">
   
      <!-- Modal -->
      <div id="modalTHPT" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 id="h4-THPT" class="modal-title">Thêm Trường THPT</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <input type="hidden" value="insert" id="querry">
                      
                      <label for="textbox1">*Mã số:</label>
                      <input class="form-control" id="thpt-maso" placeholder="Nhập mã số" type="text"/>

                      <label for="textbox2">*Tên:</label>
                      <input class="form-control" id="thpt-ten" placeholder="Nhập tên" type="text"/>

                      <label id='lb-mk1' for="textbox2">*Mật khẩu:</label>
                      <input class="form-control" id="thpt-pass1" name="matkhau" placeholder="Nhập mật khẩu" type="password"/>

                      <label id='lb-mk2' for="textbox2">*Mật khẩu lại:</label>
                      <input class="form-control" id="thpt-pass2" placeholder="Nhập lại mật khẩu" type="password"/>

                      <label for="textbox2">*Nhập địa chỉ:</label>
                      <input class="form-control" id="thpt-diachi" placeholder="Nhập địa chỉ" type="text"/>

                      <label for="textbox2">*Số điện thoại:</label>
                      <input class="form-control" id="thpt-sdt" placeholder="Nhập số điện thoại" type="text"/>

                      <label for="textbox2">Email:</label>
                      <input class="form-control" id="thpt-email" placeholder="Nhập email" type="email"/>
                 </div>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btn-themTHPT"  class="btn btn-default" onclick="submitTHPT()">Cập Nhật</button>
              </div>
          </div>
        </div>
      </div> {{-- het modal them thpt --}}

   
    <!-- Modal -->
      <div id="modalExcelTHPT" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 id="h4-ExcelTHPT" class="modal-title">Thêm Trường THPT</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <input type="hidden" value="insert" id="querry">
                    
                      <label for="textbox2">File mẫu:</label>
                      <a href="{!!asset('public/files/FileMauTHPT.xlsx')!!}" >File mẫu</a>
                      <br/>
                      <label for="">Upload File:</label>
                      <input type="file" id="thptfile" class="form-control">

                 </div>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btn-themExcelTHPT" data-dismiss="modal" class="btn btn-default" onclick="submitExcelTHPT()">Cập Nhật</button>
              </div>
          </div>
        </div>
      </div> {{-- het modal them thpt excel--}}

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

 		<table id="tableTHPT" class="table table-bordered table-hover table-striped">
 			<thead>
 				<tr>
           <th></th>
 					<th>Mã Số</th>
 					<th>Tên</th>
          <th>Địa Chỉ</th>
          <th>Số Điện Thoại</th>
          <th>Email</th>
          <th></th>
 				</tr>
 			</thead>
 			<tbody>
				  	<tr>
              <td> </td>
   						<td> </td>
              <td> </td>
              <td></td>
              <td>  </td>
   						<td> </td>
   					</tr>
 				
 			</tbody>
 		</table>
			
 	</div>
 </div>

 <script>
        $(document).ready(function () {
            $('#qlthpt').addClass('active');
        });

</script>


@endsection()