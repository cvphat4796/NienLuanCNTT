@extends('layouts.dhlayout')
@section('title','Danh Sách Ngành Xét Tuyển')
@section('content')
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="{!!asset('public/js/truongdh/ajax-table-nganh.js')!!}"></script>
 <div class="row">
 	<div class="col-xs-12 col-sm-12  col-md-12  col-lg-12 ">
   {{--  modal them hoc sinh --}}
   
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
                           <div>
                        <input class="form-control pull-left"  style="width: 85%" id="nganh-ten" placeholder="Nhập tên" type="text"/>
                          <button type="button" class="btn btn-info" onclick="addCN()" id="chuyenNganh"><i class="glyphicon glyphicon-plus"></i></button>
                        </div>
                          <div id="cn_ten" ></div>
                       
                    
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
                                 {{ $khoi->khoi_ten }}
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
      </div> {{-- het modal them Nganh --}}

    
    <!-- Modal -->
      <div id="modalNganhExcel" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 id="h4-ExcelNganh" class="modal-title">Thêm Ngành</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <input type="hidden" value="insert" id="querry">
                      <label for="textbox2">File mẫu:</label>
                      <a href="{!!asset('public/files/FileMauThemNganh.xlsx')!!}" >File mẫu</a>
                      <br/>
                      <label for="">Upload File:</label>
                      <input type="file" id="nganhfiles" class="form-control">

                 </div>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btn-themNganhExcel" data-dismiss="modal" class="btn btn-default" onclick="submitNganhExcel()">Cập Nhật</button>
              </div>
          </div>
        </div>
      </div> {{-- het modal them Nganh excel--}}

       <!-- Modal -->
      <div id="modalDiemChuan" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 id="h4-ExcelDiemChuan" class="modal-title">Thêm Điểm Chuẩn</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <input type="hidden" value="insert" id="querry">
                      <label for="textbox2">File mẫu:</label>
                      <a href="{!!asset('public/files/FileMauThemDiemChuan.xlsx')!!}" >File mẫu</a>
                      <br/>
                      <label for="">Upload File:</label>
                      <input type="file" id="diemchuanfiles" class="form-control">

                 </div>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btn-themNganhExcel" data-dismiss="modal" class="btn btn-default" onclick="submitDiemChuan()">Cập Nhật</button>
              </div>
          </div>
        </div>
      </div> {{-- het modal them Nganh excel--}}
      <!-- Modal -->
      <div id="modalHoSo" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 id="h4-hoso" class="modal-title">Thêm Học Sinh</h4>
              </div>
              <div class="modal-body">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btn-hoso" data-dismiss="modal" class="btn btn-default" onclick="submitHoSo()">Cập Nhật</button>
              </div>
          </div>
        </div>
      </div> {{-- het modal them Nganh excel--}}


   
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
            $('#qlnganh').addClass('active');
        });

</script>


@endsection()