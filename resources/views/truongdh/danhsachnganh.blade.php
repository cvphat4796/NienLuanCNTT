@extends('layouts.dhlayout')
@section('title','Danh Sách Ngành Xét Tuyển')
@section('content')

<script type="text/javascript" src="{!!asset('public/js/ajax-table-nganh.js')!!}"></script>
 <div class="row">
 	<div class="col-xs-12 col-sm-12  col-md-12  col-lg-12 ">
   {{--  modal them hoc sinh --}}
    <div class="pull-left" style="position: relative;">
        <button type="button" class="btn btn-info btnThemNganh" id="showDialogNganh" data-toggle="modal" data-target="#modalNganh">Thêm Ngành
        </button>
       
    </div>
      <!-- Modal -->
      <div id="modalNganh" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 id="h4-Nganh" class="modal-title">Thêm Ngành</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <input type="hidden" value="insert" id="querry">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        
                        <label for="textbox1">*Mã số:</label>
                        <input id="nganh-id" type="hidden"/>
                        <input class="form-control" id="nganh-maso" placeholder="Nhập mã số" type="text"/>

                        <label for="textbox2">*Tên:</label>
                        <input class="form-control" id="nganh-ten" placeholder="Nhập tên" type="text"/>
                    
                        <label for="textbox2">*Chỉ Tiêu:</label>
                        <input class="form-control" id="nganh-chitieu" placeholder="Nhập chỉ tiêu" type="number"/>

                        <label for="textbox2">Điểm Chuẩn:</label>
                        <input class="form-control" id="nganh-diemchuan" placeholder="Nhập điểm chuẩn" type="number"/>

                        <label for="textbox2">*Bậc Học:</label>
                        <select id="bh" class="form-control">
                                  <option value="DH">Đại Học</option>   
                                  <option value="CD">Cao Đẳng</option>                   
                        </select>

                        <label for="textbox2">*Chọn Khối Xét Tuyển:</label>
                       <div class="form-check" id="check-khoi">
                         @foreach ($khois as $khoi)
                              <label class="form-check-label">
                                <input type="checkbox" name="checkNganh[]" id="{{ $khoi->khoi_maso  }}" class="form-check-input" value='{{ $khoi->khoi_maso  }}'>
                                 {{ $khoi->khoi_mota }}
                              </label>
                         @endforeach    
                         
                        
                      </div>
                    </div>
                  </div>
                  
                </div>
                </div>
                  
              <div class="modal-footer">
                  <button type="button" id="btn-themNganh"  class="btn btn-default" onclick="submitNganh()">Cập Nhật</button>
              </div>
          </div>
        </div>
      </div> {{-- het modal them HS --}}

    <div class="pull-left" style="position: relative; left: 10px;">
       <button type="button" class="btn btn-info btnThemKhoi-MH" id="showDialogExcelHS" data-toggle="modal" data-target="#modalExcelHS">Thêm Ngành File Excel</button>
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
                  <button type="button" id="btn-themNganhExcel" data-dismiss="modal" class="btn btn-default" onclick="submitNganhExcel()">Cập Nhật</button>
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

 		<table id="tableNganh" class="table table-bordered table-hover table-striped">
 			<thead>
 				<tr>
          <th>STT</th>
 					<th>Mã Số</th>
 					<th>Tên</th>
          <th>Tổ Hợp Môn Xét</th>
          <th>Chỉ Tiêu</th>
          <th>Bậc Học</th>
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