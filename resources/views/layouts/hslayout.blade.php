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
          <div class="col-xs-12 col-sm-12 col-md-push-1 col-md-9 col-lg-9 tieude">
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
                      <li> <a href="/hoc-sinh/thong-tin">Thông Tin</a>  <li>
                      <li> <a href="/dang-xuat" >Đăng xuất</a></li>
                      <li><a onclick="dmk();" >Đổi Mật Khẩu</a></li>
                             
                  </ul>
              </span>
            </div>
      
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
               <li id="tths" ><a href="/hoc-sinh/thong-tin">Thông Tin Học Sinh</a></li>
               <li id="hs-nop" ><a href="/hoc-sinh/danh-sach-nganh">Danh Sách Ngành</a></li>
                
               
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                 <span class="dropdown-toggle xinchao"  id="xinchao2" data-toggle="dropdown">Xin Chào: {!! Auth::user()['user_name'] !!}<b class="caret"></b></span>
                  <ul class="dropdown-menu">
                     <li> <a href="/hoc-sinh/thong-tin">Thông Tin</a>  <li>
                    
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
</body>
</html>
