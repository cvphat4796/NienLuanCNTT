@extends('layouts.bgdlayout')
@section('title','Trang Bộ Giáo Dục')
@section('content')

<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.16/dataRender/datetime.js"></script>
 <script type="text/javascript" src="{!!asset('public/js/bogds/xu-ly-thoi-gian.js')!!}"></script>
  <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 text-center">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    Danh Sách Thời Gian
                </div>
                <div class="panel-body">
                  <div class="bgd-btn-them text-left">
                    <button class="btn btn-primary" onclick="showThemTG();"><i class="glyphicon glyphicon-plus"></i> Thêm</button>
                  </div>
                    
                    <table id='table-thoigian' class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>Loại Thời Gian</th>
                          <th>Ngày Bắt Đâu</th>
                          <th>Ngày Kết Thúc</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                </div>
              </div>
                <!-- Modal -->
<div class="modal fade text-left" id="modalThemTG" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="modalLabelTG">Thêm Thời Gian</h4>
               
            </div>
            <div class="modal-body">
              <input type="hidden" id="query" value="insert">
              <label for="textbox1">*Loại Thời Gian:</label>
              <select  id="ltg" class="form-control">
                @foreach($ltg as $tg)
                  <option value="{{ $tg->ltg_maso }}">{{ $tg->ltg_ten }}</option>
                @endforeach
              </select>
              <input type="hidden" id="id_ltg" value=''>
              <label for="textbox1">*Ngày Bắt Đầu:</label>
              <input class="form-control ngay" id="datebegin" type="text"/>

              <label for="textbox2">*Ngày Kết Thúc:</label>
              <input class="form-control ngay" type="text" id="dateend" />
            
            </div>
            <div class="modal-footer"> 
                <button type="button" onclick="themTG();" class="btn btn-primary"> Cập Nhật</button>
               
            </div>
            
           
        </div>
    </div>
</div> {{-- het modal them sua xoa thoi gian --}}
           </div>
           <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 text-center">
              <div class="panel panel-success">
                  <div class="panel-heading">
                      Danh Sách Loại Thời Gian
                  </div>
                  <div class="panel-body text-left">
                   
                      <table id='table-ltg' class="table table-hover table-bordered">
                        <thead>
                          <tr>
                            <th>Mã Loại</th>
                            <th>Tên Loại</th>
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
            $('#qlthoigian').addClass('active');
        });

</script>

@endsection()