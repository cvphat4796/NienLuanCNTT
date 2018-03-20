
<!DOCTYPE html>
<html>
<head>

  <script>
    var msg = '{{Session::get('failed')}}';
    var exist = '{{Session::has('failed')}}';
    if(exist){
      alert(msg);
    }
</script>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{!!asset('public/css/bootstrap.css')!!}">
    <link rel="stylesheet" href="{!!asset('public/css/Site.css')!!}" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="{!!asset('public/js/bootstrap.js')!!}"></script>
    <script type="text/javascript" src="{!!asset('public/js/1.js')!!}"></script>
    <script src="https://datatables.yajrabox.com/js/jquery.dataTables.min.js"></script>
    <script src="https://datatables.yajrabox.com/js/datatables.bootstrap.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>
<body>
   <div class="container" >
      <div class="row">
        <div class="banner">
          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 icon">
            
          </div>
          <div class="col-xs-7 col-sm-7 col-md-8 col-lg-8 tieude">
            <span>Bộ Giáo Dục và Đào Tạo</span> 
            <br/>
            Hệ Thống Quản Lý điểm & Xét Tuyển đại Học
          </div>
          <div class="col-xs-3 col-sm-3 col-md-2 col-lg-2 form-dangnhap ">
            <form action="/dang-nhap" id="login"  method="post" class="form-inline">
              {{ csrf_field() }}
              <div class="form-group tieudedangnhap">
                Đăng Nhập
              </div>
              <div class="form-group ">
                <input type="text" name="user" class="form-control" id="user" placeholder="Tên đăng nhập">
              </div>
              <div class="form-group ">
                <input type="password" name="pass" class="form-control" id="pass" placeholder="Mật khẩu">
              </div>
              <div class="form-group text-center">
                
              <input type="submit" class="btn btn-default "  value="Đăng Nhập"/>
              </div>
            </form>
            
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
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav">
            <li id="trangchu"><a href="/">Xem Điểm</a></li>
            <li id="tuyensinh"><a href="/nganh-hoc">Xem Ngành Học</a></li>
          </ul>
              @if (isset($listdiem))
                <ul class="nav navbar-nav navbar-right timkiemmenu">
                  <form class="navbar-form navbar-left" role="search">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nhập số báo danh">
                      </div>
                      <button type="submit" class="btn btn-default">Tìm Kiếm</button>
                    </form>     
                </ul>

              @endif
          
        </div><!-- /.navbar-collapse -->
      </div>
    </nav>
    </div> <!-- ket thuc menu -->

    <div class="container">
      
    @yield('content')
  

 
</body>
</html>
