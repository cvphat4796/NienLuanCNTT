@extends('layouts.bgdlayout')
@section('title','Danh Sách Trường THPT')
@section('content')

<script type="text/javascript" src="{!!asset('public/js/bogds/ajax-table-thpt.js')!!}"></script>
 <div class="row">
 	<div class="col-xs-12 col-sm-12  col-md-12  col-lg-12 ">
    <div class="panel panel-default">
      <div class="panel-heading text-center">
       Danh Sách Trường THPT
      </div>
      <div class="panel-body">
        <table id="tableTHPT" class="table table-hover table-striped table-bordered">
          <thead>
            <tr>
              <th></th>
              <th>STT</th>
              <th>Mã Số</th>
              <th>Tên</th>
              <th>Địa Chỉ</th>
              <th>Số Điện Thoại</th>
              <th>Email</th>
              <th>Sở Giáo Dục</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
                <tr>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                </tr>
            
          </tbody>
          <tfoot>
              <tr>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                  <td> </td>
                </tr>
          </tfoot>
        </table>
      </div>
    </div>
    
 	</div>

<div class="modal fade text-left" id="modalTHPT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="modalLabelTHPT">Sửa Thông Tin</h4>
            </div>
            <div class="modal-body">
              <input type="hidden" id="querry" value="update">
              
              <label for="textbox1">*Mã Số:</label>
              <input class="form-control" id="thpt-maso" type="text"/>

              <label for="textbox2">*Tên:</label>
              <input class="form-control" type="text" id="thpt-ten" />

              <label for="textbox2">*Địa Chỉ:</label>
              <input class="form-control" type="text" id="thpt-diachi" />

              <label for="textbox2">*Số Điện Thoại:</label>
              <input class="form-control" type="number" id="thpt-sdt" />

              <label for="textbox2">*Sở Giáo Dục:</label>
              <select class="form-control"  id="sogd">
                @foreach($sgds as $sgd)
                  <option value="{{ $sgd->user_id }}">{{ $sgd->user_name }}</option>
                @endforeach
              </select>

              <label for="textbox2">Email:</label>
              <input class="form-control" type="email" id="thpt-email" />
            
            </div>
            <div class="modal-footer"> 
                <button type="button" onclick="submitTHPT();" class="btn btn-primary"> Cập Nhật</button>
               
            </div>
            
           
        </div>
    </div>
</div> {{-- het modal them sua xoa thoi gian --}}
 </div>

 <script>
        $(document).ready(function () {
            $('#qltaikhoan').addClass('active');
        });

</script>


@endsection()