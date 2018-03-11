@extends('layouts.sgdlayout')
@section('title','Danh Sách Các Trương THPT')
@section('content')

<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/dataRender/datetime.js"></script>
<script type="text/javascript" src="{!!asset('public/js/ajax-table-hocsinh.js')!!}"></script>
 <div class="row">
 	<div class="col-xs-12 col-sm-12  col-md-12  col-lg-12 ">
    <div class="pull-left" style="position: relative;">
        <button type="button" class="btn btn-info btnThemKhoi-MH" id="showDialogHS" data-toggle="modal" data-target="#modalHS">Thêm Học Sinh</button>
       
    </div>
      <!-- Modal -->
      <div id="modalHS" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 id="h4-HS" class="modal-title">Thêm Học Sinh</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                      <div class="form-group">
                        <input type="hidden" value="insert" id="querry">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        
                        <label for="textbox1">*Mã số:</label>
                        <input class="form-control" id="hs-maso" placeholder="Nhập mã số" type="text"/>

                        <label for="textbox2">*Tên:</label>
                        <input class="form-control" id="hs-ten" placeholder="Nhập tên" type="text"/>

                        <label id='lb-mk1' for="textbox2">*Mật khẩu:</label>
                        <input class="form-control" id="hs-pass1" name="matkhau" placeholder="Nhập mật khẩu" type="password"/>

                        <label id='lb-mk2' for="textbox2">*Mật khẩu lại:</label>
                        <input class="form-control" id="hs-pass2" placeholder="Nhập lại mật khẩu" type="password"/>

                        <label for="textbox2">*Nhập địa chỉ:</label>
                        <input class="form-control" id="hs-diachi" placeholder="Nhập địa chỉ" type="text"/>

                        <label for="textbox2">*Số điện thoại:</label>
                        <input class="form-control" id="hs-sdt" placeholder="Nhập số điện thoại" type="text"/>

                       
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                      <div class="form-group">
                          <label for="textbox2">*Chọn trường THPT:</label>
                          <select id="thpt" class="form-control">
                              @foreach ($thpts as $thpt)
                                  <option value="{{ $thpt->user_id  }}">{{ $thpt->user_name }}</option>
                              @endforeach                                       
                          </select>
                                    
                          <label for="textbox2">*Chọn khu vực:</label>
                          <select id="kv_maso" class="form-control">
                              @foreach ($khuvucs as $khuvuc)
                                  <option value="{{ $khuvuc->kv_maso  }}">{{ $khuvuc->kv_ten }}</option>
                              @endforeach                                       
                          </select>

                          <label for="textbox2">*Giới tính:</label>
                          <select id="gioitinh" class="form-control">
                            <option value="nam">Nam</option>
                            <option value="nu">Nữ</option>
                          </select>
                                    
                          <label for="textbox2">*Ngày sinh:</label>
                          <input class="form-control ngay" id="hs-ngaysinh" placeholder="Nhập ngày sinh" type="text"/>

                          <label for="textbox2">*Số CMND:</label>
                          <input class="form-control" id="hs-cmnd" placeholder="Nhập số cmnd" type="number"/>
                          
                          <label for="textbox2">Email:</label>
                          <input class="form-control" id="hs-email" placeholder="Nhập email" type="email"/>
                      </div>
                  </div>
                </div>
                </div>
                  
              <div class="modal-footer">
                  <button type="button" id="btn-themHS"  class="btn btn-default" onclick="submitHS()">Cập Nhật</button>
              </div>
          </div>
        </div>
      </div> {{-- het modal them HS --}}

    <div class="pull-left" style="position: relative; left: 160px;">
       <button type="button" class="btn btn-info btnThemKhoi-MH" id="showDialogExcelHS" data-toggle="modal" data-target="#modalExcelHS">Thêm Học Sinh Bằng File Excel</button>
    </div>
    <!-- Modal -->
      <div id="modalExcelHS" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 id="h4-ExcelHS" class="modal-title">Thêm Học Sinh</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <input type="hidden" value="insert" id="querry">
                      <meta name="csrf-token" content="{{ csrf_token() }}">
                      <label for="textbox2">File mẫu:</label>
                      <a href="{!!asset('public/files/FileMauHocSinh.xlsx')!!}" >File mẫu</a>
                      <br/>
                      <label for="">Upload File:</label>
                      <input type="file" id="hsfile" class="form-control">

                 </div>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btn-themExcelHS" data-dismiss="modal" class="btn btn-default" onclick="submitExcelHS()">Cập Nhật</button>
              </div>
          </div>
        </div>
      </div> {{-- het modal them HS excel--}}

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

 		<table id="tableHS" class="table table-bordered table-hover table-striped">
 			<thead>
 				<tr>
 					<th>Mã Số</th>
 					<th>Tên</th>
          <th>Số Điện Thoại</th>
          <th>Giới Tính</th>
          <th>Số CMND</th>
          <th>Ngày Sinh</th>
          <th>Địa Chỉ</th>
          <th>Trương THPT</th>
          <th></th>
 				</tr>
 			</thead>
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
   						<td></td>
   					</tr>
 				
 			</tbody>
 		</table>
			
 	</div>
 </div>

 <script>
        $(document).ready(function () {
            $('#qlhs').addClass('active');
        });

</script>


@endsection()