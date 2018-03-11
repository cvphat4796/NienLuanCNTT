<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{!!asset('public/js/bootstrap-datepicker.js')!!}"></script>
    <script type="text/javascript" src="{!!asset('public/js/bootstrap.js')!!}"></script>
    <script type="text/javascript" src="{!!asset('public/js/1.js')!!}"></script>
    <script src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script>
    <script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>

    <link rel="stylesheet" href="{!!asset('public/css/datepicker.css')!!}">
    <link rel="stylesheet" href="{!!asset('public/css/bootstrap.css')!!}">
    <link rel="stylesheet" href="{!!asset('public/css/Site.css')!!}" />


</head>
<body>
   <div class="container">
      <div class="row">
        <div class="banner">
          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 icon">
            
          </div>
          <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 tieude">
            <span>Bộ Giáo Dục và Đào Tạo</span> 
            <br/>
            Hệ Thống Quản Lý điểm & Xét Tuyển đại Học
          </div>
          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center info ">
            <a href="/bo-giao-duc/thong-tin">Id: {!! Auth::id() !!}</a>
            <br/>
            <a href="/dang-xuat" class="btn btn-default">Đăng xuất</a>
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
          <span class="navbar-brand hidden" id="xinchao1">Xin Chào: {!! Auth::user()['user_name'] !!}</span>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav">
             <li id="qlthoigian" ><a href="/bo-giao-duc">Quản Lý Thời Gian</a></li>
                     
                     <li id="qltaikhoan" class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">Quản Lý Tài Khoản <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/bo-giao-duc/tao-tai-khoan">Tạo Tài Khoản</a></li>
                            <li><a href="/bo-giao-duc/tai-khoan/sgd">Tài Khoản Sở GD</a></li>
                            <li><a href="/bo-giao-duc/tai-khoan/dh">Tài Khoản Trường ĐH</a></li>
                            <li><a href="/so-giao-duc/tai-khoan-thpt">Tài Khoản Trường THPT</a></li>
                            <li><a href="/thpt/tai-khoan-hs">Tài Khoản Học Sinh</a></li>
                        </ul>
                    </li>
                    <li id="qlkhoinganh"><a href="/bo-giao-duc/ql-khoi-nganh">Quản Lý Khối Ngành</a></li>

          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><span class="xinchao" id="xinchao2">Xin Chào: {!! Auth::user()['user_name'] !!}</span></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div>
    </nav>
    </div> <!-- ket thuc menu -->
    
     <div class="container">
        @yield('content')
 
    </div>

 
   
</body>
</html>
