@extends('layouts.bgdlayout')
@section('title','Trang Bộ Giáo Dục')
@section('content')
<script>
    var msg = '{{Session::get('status')}}';
    var exist = '{{Session::has('status')}}';
    if(exist){
      alert(msg);
    }
</script>
  <div class="row">
            <form action="/bo-giao-duc/quan-ly-thoi-gian" method="post">
                 {{ csrf_field() }}
                <div class="col-md-4 col-md-push-4 form-group thoigian">

                    <label for="textbox1">Ngày Bắt Đầu:</label>
                    <input class="form-control ngay" name="datebegin" type="text"/>

                    <label for="textbox2">Ngày Kết Thúc:</label>
                    <input class="form-control ngay" type="text" name="dateend" />

                    <label for="textbox2">Mô Tả:</label>
                    <textarea name="mota" class="form-control"></textarea>

                    <div class="text-right">
                        <input type="submit" value="Cập Nhật" class="btn btn-default">                  
                    </div>
              
                </div>  
            </form>            
      </div>

    @if(!empty($thoigians))
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
         <div class="class-btn text-left">
            <button id="myBtn"  data-toggle="modal" data-target="#myModal">edit</button>
            <button>delete</button>
          </div>  
      </div>
     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
       <div class="search text-right">
          <span>Search:</span>
         <input type="text" >
       </div>
     </div>
    </div>
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <table class="table table-hover">
                  <thead>
                      <tr>
                          <th><input type="checkbox" name="check[]" class="form-control"></th>
                          <th>Người cập nhật</th>
                          <th>Thời gian bắt đầu</th>
                          <th>Thời gian kết thúc</th>
                          <th>Mô tả</th>
                          <th>Chỉnh sửa</th>
                      </tr>
                  </thead>
                  <tbody>
                     @foreach ($thoigians as $th)
                        <tr>
                            <td><input type="checkbox" name="check[]" id="{{ $th->tg_maso }}" class="form-control"></td>
                            <td> {{ $th->user_name }} </td>
                            <td> {{ date('d-m-Y', strtotime($th->tg_batdau)) }} </td>
                            <td> {{ date('d-m-Y', strtotime($th->tg_ketthuc)) }} </td>
                            <td> {{ $th->tg_mota }} </td>
                            <td> 
                                
                                <form action="/bo-giao-duc/xoa-thoi-gian" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $th->tg_maso }}">
                                    <input type="submit" value="Xóa" class="btn btn-danger">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    @endif

    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
          <form method="post" action"/bo-giao-duc1">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="myModalLabel">Edit</h4>

            </div>
            <div class="modal-body">
           
              <input type="text" name="xxx">
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="save"/>
            </div>
            
           
          </form>
        </div>
    </div>
</div>
<script>
        $(document).ready(function () {
            $('#qlthoigian').addClass('active');
        });

</script>

@endsection()