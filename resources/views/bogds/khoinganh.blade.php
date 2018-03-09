@extends('layouts.bgdlayout')
@section('title','Quản lý khối ngành')
@section('content')


<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="text-left">
        <button type="button" class="btn btn-info btnThemKhoi-MH" id="showDialogMH" data-toggle="modal" data-target="#myModal">Thêm Môn Học</button>
    </div>
      <!-- Modal -->
      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Thêm Môn Học</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <input type="hidden" value="insert" id="querry">
                      <meta name="csrf-token" content="{{ csrf_token() }}">
                      <label for="textbox1">*Mã số:</label>
                      <input class="form-control" name="maso" id="mh_maso" placeholder="Nhập mã số" type="text"/>

                      <label for="textbox2">*Tên:</label>
                      <input class="form-control" name="ten" id="mh_ten" placeholder="Nhập tên" type="text"/>
                 </div>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btn-themMH" data-dismiss="modal" class="btn btn-default" onclick="submit()">Cập Nhật</button>
              </div>
          </div>
        </div>
      </div> {{-- het modal them mon hoc --}}
		  
      <table id="tableMH" class="table table-hover">
        <thead>
          <tr>
            <th>Mã Số</th>
            <th>Tên</th>
            <th></th>
          </tr>
        </thead>
        <tbody >
            <tr>
              <td> </td>
              <td> </td>
              <td> </td>
            </tr>
        </tbody>
      </table>
      {{-- table mon hoc --}}

	</div> {{-- het cot mon hoc --}}
  
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="text-left">
        <button type="button" class="btn btn-info btnThemKhoi-MH" id="showDialogKhoi" data-toggle="modal" data-target="#modalKhoi">Thêm Khối</button>
    </div>
      <!-- Modal -->
      <div id="modalKhoi" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close " data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Thêm Khối</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <input type="hidden" value="insert" id="querryKhoi">
                      <label for="textbox1">*Mã số:</label>
                      <input class="form-control" name="maso" id="khoi_maso" placeholder="Nhập mã số" type="text"/>

                      <label for="textbox2">*Tên Khối:</label>
                      <input class="form-control" name="ten" id="khoi_ten" placeholder="Nhập tên" type="text"/>
                 </div>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btn-themKhoi" data-dismiss="modal" class="btn btn-default" onclick="submitKhoi()">Cập Nhật</button>
              </div>
          </div>
        </div>
      </div> {{-- het modal them mon hoc --}}
      
      <table id="tableKhoi" class="table table-hover">
        <thead>
          <tr>
            <th>Mã Số</th>
            <th>Tên</th>
            <th></th>
          </tr>
        </thead>
        <tbody >
            <tr>
              <td> </td>
              <td> </td>
              <td> </td>
            </tr>
        </tbody>
      </table>
      {{-- table khoi --}}

  </div>
   {{-- het cot khoi --}}
  
  
  

</div> {{-- het row 1 --}}

<div class="row">
 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <form action="them-khoi-nganh" method="post">
      {{ csrf_field() }}
      <div class="panel panel-default">
        <div class="panel-heading text-center">
          Thêm Khối Ngành
        </div>
        <div class="panel-body">
          <div class="form-group">
              <label for="textbox1">*Chọn Khối:</label>
              <select class="form-control" name="khoi" id="">
                 @foreach ($khoi as $k)
                    <option value="{{ $k->khoi_maso  }}">{{ $k->khoi_mota }}</option>
                                           
                 @endforeach 
              </select>

              <label for="textbox2">*Chọn Môn 1:</label>
               <select class="form-control" name="mon1" id="">
                 @foreach ($monhoc as $mh)
                    <option value="{{ $mh->mh_maso  }}">{{ $mh->mh_ten }}</option>
                                           
                 @endforeach 
              </select>

              <label for="textbox2">*Chọn Môn 2:</label>
               <select class="form-control" name="mon2" id="">
                 @foreach ($monhoc as $mh)
                    <option value="{{ $mh->mh_maso  }}">{{ $mh->mh_ten }}</option>
                                           
                 @endforeach 
              </select>

              <label for="textbox2">*Chọn Môn 3:</label>
               <select class="form-control" name="mon3" id="">
                 @foreach ($monhoc as $mh)
                    <option value="{{ $mh->mh_maso  }}">{{ $mh->mh_ten }}</option>
                                           
                 @endforeach 
              </select>
          </div>
          <div class="text-right">
                                <input type="submit" value="Cập Nhật" class="btn btn-default">                  
                    </div>
        </div>
      </div>
    </form>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="text-left">
        <button type="button" class="btn btn-info btnThemKhoi-MH" id="showDialogKhoiNganh" data-toggle="modal" data-target="#modalKhoiNganh">Thêm Khối</button>
    </div>
      <!-- Modal -->
      <div id="modalKhoiNganh" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close " data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Thêm Khối</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <input type="hidden" value="insert" id="querryKhoiNganh">
                      <label for="textbox1">*Mã số:</label>
                      <input class="form-control" name="maso" id="khoi_maso" placeholder="Nhập mã số" type="text"/>

                      <label for="textbox2">*Tên Khối:</label>
                      <input class="form-control" name="ten" id="khoi_ten" placeholder="Nhập tên" type="text"/>
                 </div>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btn-themKhoiNganh" data-dismiss="modal" class="btn btn-default" onclick="submitKhoiNganh()">Cập Nhật</button>
              </div>
          </div>
        </div>
      </div> {{-- het modal them mon hoc --}}
      
      <table id="tableKhoiNganh" class="table table-hover">
        <thead>
          <tr>
            <th>Khối</th>
            <th>Môn 1</th>
            <th>Môn 2</th>
            <th>Môn 3</th>
            <th></th>
          </tr>
        </thead>
        <tbody >
            <tr>
              <td> </td>
              <td> </td>
              <td> </td>
              <td> </td>
              <td> </td>
            </tr>
        </tbody>
      </table>
      {{-- table khoi nganh --}}
  </div>
</div>

<script>
        $(document).ready(function () {
            $('#qlkhoinganh').addClass('active');
        });

</script>
@endsection()