<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
 <meta name="csrf-token" content="{{ csrf_token() }}">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{!!asset('public/css/bootstrap.css')!!}">
    <link rel="stylesheet" href="{!!asset('public/css/Site.css')!!}" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="{!!asset('public/js/bootstrap.js')!!}"></script>
     <script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="{!!asset('public/js/1.js')!!}"></script>
</head>
<body>
   <div class="container">
      <div class="row">
        <div class="banner">
          <div class="hidden-xs hidden-sm col-md-2 col-lg-2 icon">
            
          </div>
          <div class="col-xs-12 col-sm-12 col-md-push-1 col-md-8 col-lg-8 tieude">
            <span>Bộ Giáo Dục và Đào Tạo</span> 
            <br/>
            Hệ Thống Quản Lý điểm & Xét Tuyển đại Học
          </div>
        
        </div>
      </div>
    </div> <!-- ket thuc banner -->

    <div class="container">
      <nav class="navbar navbar-default" role="navigation">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <span class="navbar-brand hidden dropdown"  id="xinchao1">
             <span class="dropdown-toggle xinchao"   data-toggle="dropdown">Xin Chào: {!! Auth::user()['user_name'] !!}<b class="caret"></b></span>
              <ul class="dropdown-menu">
                  <li> <a href="/bo-giao-duc">Thông Tin</a>  <li>
             
                  <li><a onclick="dmk();" >Đổi Mật Khẩu</a></li>
                  <li> <a href="/dang-xuat" >Đăng xuất</a></li>       
              </ul>
          </span>
        
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav">
              <li id="qlthoigian" ><a href="/bo-giao-duc/thoi-gian">Quản Lý Thời Gian</a></li>
              <li id="qltaikhoan" class="dropdown">
                  <a href="" class="dropdown-toggle" data-toggle="dropdown">Quản Lý Tài Khoản <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                          <li><a href="/bo-giao-duc/tao-tai-khoan">Tạo Tài Khoản</a></li>
                          <li><a href="/bo-giao-duc/tai-khoan/sgd">Tài Khoản Sở GD</a></li>
                          <li><a href="/bo-giao-duc/tai-khoan/dh">Tài Khoản Trường ĐH</a></li>
                          <li><a href="/bo-giao-duc/tai-khoan-thpt">Tài Khoản Trường THPT</a></li>
                          <li><a href="/bo-giao-duc/tai-khoan-hs">Tài Khoản Học Sinh</a></li>
                      </ul>
              </li>
                
          </ul>
          <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
             <span class="dropdown-toggle xinchao"  id="xinchao2" data-toggle="dropdown">Xin Chào: {!! Auth::user()['user_name'] !!}<b class="caret"></b></span>
              <ul class="dropdown-menu">
                 <li> <a href="/bo-giao-duc">Thông Tin</a>  <li>
                  
                  <li><a  onclick="dmk();" >Đổi Mật Khẩu</a></li>
                   <li> <a href="/dang-xuat" >Đăng xuất</a></li>      
              </ul>
          </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div>
    </nav>
    </div> <!-- ket thuc menu -->
    
     <div class="container">
        @yield('content')
 
    </div>

  <div class="modal fade text-left" id="modalDMK" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="modalLabelKhoi">Đổi Mật Khẩu</h4>
            </div>
            <div class="modal-body">
              <label for="textbox1">*Mật Khẩu Củ:</label>
              <input class="form-control" id="mk-cu" type="password"/>
               <label for="textbox1">*Mật Khẩu Mới:</label>
              <input class="form-control" id="mk-moi1" type="password"/>
               <label for="textbox1">*Nhập Lại:</label>
              <input class="form-control" id="mk-moi2" type="password"/>
            </div>
            <div class="modal-footer"> 
                <button type="button" onclick="submitDMK();" class="btn btn-primary"> Cập Nhật</button>
               
            </div>
            
           
        </div>
    </div>
</div> {{-- Doi Mat Khau --}}
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

   
</body>
</html>
