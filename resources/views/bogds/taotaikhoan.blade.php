@extends('layouts.bgdlayout')
@section('title','Tạo Tài Khoản')
@section('content')
<script>
    var msg = '{{Session::get('status')}}';
    var exist = '{{Session::has('status')}}';
    if(exist){
      alert(msg);
    }
</script>
<script type="text/javascript" src="{!!asset('public/js/ajax-tao-tai-khoan-bgd.js')!!}"></script>
 <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Nhập Thông Tin</div>
                    <form id="form-taikhoan" action="/bo-giao-duc/tao-tai-khoan" method="post">
                    	{{ csrf_field() }}
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="textbox1">*Mã số:</label>
                                <input class="form-control" name="maso" placeholder="Nhập mã số" type="text"/>

                                <label for="textbox2">*Tên:</label>
                                <input class="form-control" name="ten" placeholder="Nhập tên" type="text"/>

                                <label for="textbox2">*Mật khẩu:</label>
                                <input class="form-control" id="pass1" name="matkhau" placeholder="Nhập mật khẩu" type="password"/>

                                <label for="textbox2">*Mật khẩu lại:</label>
                                <input class="form-control" id="pass2" placeholder="Nhập lại mật khẩu" type="password"/>

                                <label for="textbox2">*Nhập địa chỉ:</label>
                                <input class="form-control" name="diachi" placeholder="Nhập địa chỉ" type="text"/>

                                <label for="textbox2">*Số điện thoại:</label>
                                <input class="form-control" name="sdt" placeholder="Nhập số điện thoại" type="text"/>

                                <label for="textbox2">Email:</label>
                                <input class="form-control" name="email" placeholder="Nhập email" type="email"/>

                                <label for="textbox2">*Chọn người dùng:</label>
                                <select name="quyen" class="form-control" id="quyen">
                                    @foreach ($data as $quyen)
                                        @if($quyen->pq_maso == "bgd")
                                            @continue
                                        @endif
                                        <option value="{{ $quyen->pq_maso }}">{{ $quyen->pq_mota }}</option>
                                       
                                    @endforeach
                                </select>

                            </div>
                            <div id="thpt" class="hide">
                                <div class="form-group">
                                    
                                    <label for="textbox2">*Chọn Sở GD:</label>
                                    <select name="sogd" class="form-control">
                                        @foreach ($sogds as $sogd)
                                            <option value="{{ $sogd->user_id  }}">{{ $sogd->user_name }}</option>
                                           
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="hocsinh" class="hide">
                                <div class="form-group">
                                    <label for="textbox2">*Chọn trường THPT:</label>
                                    <select name="thpt" class="form-control">
                                        @foreach ($thpts as $thpt)
                                            <option value="{{ $thpt->user_id  }}">{{ $thpt->user_name }}</option>
                                           
                                        @endforeach                                       
                                    </select>
                                    
                                     <label for="textbox2">*Chọn khu vực:</label>
                                    <select name="kv_maso" class="form-control">
                                        @foreach ($khuvucs as $khuvuc)
                                            <option value="{{ $khuvuc->kv_maso  }}">{{ $khuvuc->kv_ten }}</option>
                                           
                                        @endforeach                                       
                                    </select>

                                    <label for="textbox2">*Giới tính:</label>
                                    <select name="gioitinh" class="form-control">
                                        <option value="nam">Nam</option>
                                        <option value="nu">Nữ</option>
                                    </select>
                                    
                                    <label for="textbox2">*Ngày sinh:</label>
                                    <input class="form-control ngay" name="ngaysinh" placeholder="Nhập ngày sinh" type="text"/>

                                    <label for="textbox2">*Số CMND:</label>
                                    <input class="form-control" name="cmnd" placeholder="Nhập số cmnd" type="number"/>

                                    
                                </div>
                               
                            </div>
                            <div class="text-right">
                                <input type="submit" value="Cập Nhật" class="btn btn-default">                  
                            </div>
                        </div> <!-- het body penal -->
                    </form> {{-- het form nhap thong tin --}}
                </div>  
            </div> <!-- het panel thong tin -->

            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading text-center">Tạo Tài Khoản SGD, Trường ĐH Với File Excel</div>
                    <div class="panel-body">
                       
                            <div class="form-group">
                                <label for="textbox2">File mẫu:</label>
                                <a href="{!!asset('public/files/FileMauSoGDDH.xlsx')!!}" >File mẫu</a>
                                <br/>
                                <label for="">Upload File:</label>
                                <input type="file" id="sgd_dhfile" class="form-control">

                            </div>
                            <div class="text-right">
                                <button  class="btn btn-default" onclick="submitExcelSGDDH()">Cập Nhật</button>                  
                            </div>
                    </div>
                </div>
                 <div class="panel panel-primary">
                    <div class="panel-heading text-center">Tạo Tài Khoản Trường THPT Với File Excel</div>
                    <div class="panel-body">
                        
                            <div class="form-group">
                                <label for="textbox2">File mẫu:</label>
                                <a href="{!!asset('public/files/FileMauTHPT.xlsx')!!}" >File mẫu</a>
                                <br/>
                                <label for="">Upload File:</label>
                                <input type="file" id="thptfile" class="form-control">
                                
                            </div>
                            <div class="text-right">
                                   <button  class="btn btn-default" onclick="submitExcelTHPT()">Cập Nhật</button>                  
                            </div> 
                    </div>
                </div>

                 <div class="panel panel-success">
                    <div class="panel-heading text-center">Tạo Tài Khoản Học Sinh Với File Excel</div>
                    <div class="panel-body">
                       
                            <div class="form-group">
                                <label for="textbox2">File mẫu:</label>
                                <a href="{!!asset('public/files/FileMauHocSinh.xlsx')!!}" >File mẫu</a>
                                <br/>
                                <label for="">Upload File:</label>
                                <input type="file" id="hsfile" class="form-control">
                                
                            </div>
                             <div class="text-right">
                                   <button  class="btn btn-default" onclick="submitExcelHS()">Cập Nhật</button>                  
                            </div>
                    </div>
                </div>
            </div>

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
        </div>
        {{-- {{ csrf_field() }} --}}



@endsection()