@extends('layouts.layout')
@section('title','Tuyển Sinh')
@section('content')
<div class="row">
        <div class="col-xs-4 col-xs-push-1 col-sm-9 col-sm-push-2 col-md-8 col-md-push-1 col-lg-10 ">
          <form class="navbar-form navbar-left timkiem form-inline" role="search">
            <div class="form-group ">
              <label for="truong">Chọn Trường Đại Học:</label>
              <select name="daihoc"  class="custom-select" id="daihoc" >
                            <option value="#">=====Chọn Trường=====</option>
                            <option value="CTU">CTU - Đại Học Cần Thơ</option>
                            <option value="DTHU">DTHU - Đại Học Đồng Tháp</option>
                        </select>
            </div>
                    <div class="form-group ">
                        <label for="truong">Chọn Ngành Học:</label>
                        <select name="daihoc" disabled="true" class="custom-select" id="nganh" >
                            <option value="##">=====Chọn Ngành=====</option>
                            <option value="CTU">CTU - Đại Học Cần Thơ</option>
                            <option value="DTHU">DTHU - Đại Học Đồng Tháp</option>
                        </select>
                    </div>
            <button type="submit" "  disabled="true"  class="btn btn-default" id="btn-timnganh">Tìm Kiếm</button>
          </form>
          <select id="disabledSelect" class="form-control">
        <option>Disabled select</option>
      </select>
        </div>
      </div>

<script>
        $(document).ready(function () {
            $('#tuyensinh').addClass('active');
        });

</script>

@endsection()