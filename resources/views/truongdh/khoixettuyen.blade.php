@extends('layouts.dhlayout')
@section('title','Danh Sách Khối Xét Tuyển')
@section('content')


<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="{!!asset('public/js/truongdh/ajax-xu-ly-khoixt.js')!!}"></script>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
			
		<!-- Modal -->
      <div id="modalKXT" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close " data-dismiss="modal">&times;</button>
                  <h4 id="h4-KN" class="modal-title">Thêm Tổ Hợp Môn</h4>
              </div>
              <div class="modal-body">

                  <div class="form-group">
                      <input type="hidden" value="insert" id="querryKhoiNganh">
                      <label for="textbox1">*Chọn Khối:</label>
                      <select class="form-control" name="khoi" id="sel-khoi">
                                   
                      </select>

                      <label for="textbox2">*Chọn Môn 1:</label>
                       <select class="form-control" name="mon1" id="sel-mon1">
                          @foreach($mh as $m)
                          	<option value="{{ $m->mh_maso }}">{{ $m->mh_ten }}</option>
                          @endforeach
                      </select>

                      <label for="textbox2">*Chọn Môn 2:</label>
                       <select class="form-control" name="mon2" id="sel-mon2">
                           @foreach($mh as $m)
                          	<option value="{{ $m->mh_maso }}">{{ $m->mh_ten }}</option>
                          @endforeach
                      </select>

                      <label for="textbox2">*Chọn Môn 3:</label>
                       <select class="form-control" name="mon3" id="sel-mon3">
                          @foreach($mh as $m)
                          	<option value="{{ $m->mh_maso }}">{{ $m->mh_ten }}</option>
                          @endforeach   
                      </select>
                 </div>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btn-themKXT" class="btn btn-default" onclick="submitKXT()">Cập Nhật</button>
              </div>
          </div>
        </div>
      </div> {{-- het modal them mon hoc --}}
			<div class="panel panel-primary">
				<div class="panel-heading text-center">
					Danh Sách Khối Xét Tuyển
				</div>
				<div class="panel-body">
				
					<table id='table-kxt' class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>Khối</th>
								<th>Môn 1</th>
								<th>Môn 2</th>
								<th>Môn 3</th>
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
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="padding: 0 0">
			<div class="panel panel-info">
				<div class="panel-heading text-center">
					Danh Sách Khối
				</div>
				<div class="panel-body">
					 

					<table id="table-khoi" class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>Tên Khối</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
<div class="modal fade text-left" id="modalKhoi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="modalLabelKhoi">Thêm Khối</h4>
            </div>
            <div class="modal-body">
              <input type="hidden" id="querry" value="update">
              <input type="hidden" id='ma_khoi'>
              <label for="textbox1">*Tên:</label>
              <input class="form-control" id="ten" type="text"/>
            </div>
            <div class="modal-footer"> 
                <button type="button" onclick="submitKhoi();" class="btn btn-primary"> Cập Nhật</button>
               
            </div>
            
           
        </div>
    </div>
</div> {{-- het modal them sua xoa thoi gian --}}
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<div class="panel panel-success">
				<div class="panel-heading text-center">
					Danh Sách Môn Học
				</div>
				<div class="panel-body">
					<table id='table-monhoc' class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>Mã Số</th>
								<th>Tên Môn Học</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	
 <script>
        $(document).ready(function () {
            $('#qlkhoinganh').addClass('active');
        });

</script>

@endsection