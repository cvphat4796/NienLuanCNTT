@extends('layouts.dhlayout')
@section('title','Trang Trường ĐH')
@section('content')
<div class="jumbotron text-center">
      <form action="/tim-kiem-nganh" method="post" class="form-inline">
          <div>
              <label for="keyInput">Tìm kiếm ngành học: </label>
              <input type="text" class="form-control" id="txtNganh" name="nganh" placeholder="Nhập tên ngành hoặc mã ngành" />
              <input type="submit" class="btn btn-default" value="Tìm" />
          </div>
      </form>

    <marquee>Đăng nhập tài khoản để nộp thông tin xét tuyển</marquee>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Danh Sách Ngành Xét Tuyển 2018
                </div>
                <div class="panel-body">
                    <div class="table-responsive" style="font-size: 13px">
                       
                            <table class="table table-striped table-bordered table-hover ">

                                <tr>
                                    <th>STT</th>
                                    <th>Mã Ngành</th>
                                    <th>Tên Ngành</th>
                                    <th>Chỉ Tiêu</th>
                                    <th>Tổ Hợp Môn</th>
                                    <th>Điểm Chuẩn</th>
                                </tr>
                              
                            </table>
                        
                    

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<script>
        $(document).ready(function () {
            $('#tuyensinh').addClass('active');
        });

</script>

@endsection()