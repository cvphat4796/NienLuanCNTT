@extends('layouts.layout')
@section('title','Tuyển Sinh')
@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12  col-md-12 col-lg-12 ">
          <table id="tableNganh" class="table table-bordered  table-hover table-striped">
            <thead>
              <tr>
                <th>Mã Ngành</th>
                <th>Tên Ngành</th>
                    <th>Tổ Hợp Môn Xét</th>
                    <th>Chỉ Tiêu</th>
                    <th>Điểm Chuẩn</th>
                    <th>Bậc Học</th>
                    <th>Trường Đại Học</th>
              </tr>
            </thead>
            <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                  </tr>
                </tfoot>
            <tbody>
                  <tr>
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
            $('#tuyensinh').addClass('active');
        });

</script>

@endsection()