<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

        <script type="text/javascript" src="{!!asset('public/js/jquery-1.10.2.min.js')!!}"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="{!!asset('public/css/bootstrap.min.css')!!}" />
        <link rel="stylesheet" href="{!!asset('public/css/bootstrap.css')!!}" />
        <link rel="stylesheet" href="{!!asset('public/css/Site.css')!!}" />
        <script type="text/javascript" src="{!!asset('public/js/bootstrap.min.js')!!}"></script>
</head>
<body>
    <div class="container">
        <div id="banner"><div id="img-banner"> </div></div>

        <div id="menu">
            <ul class="nav nav-pills">
                
                <li id="qlnganh" class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Quản Lý Ngành<b class="caret" style="border-top-color:#fdfdfd;"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/quan-ly-nganh">Danh Sách Ngành</a></li>
                        <li><a href="/them-nganh">Thêm Ngành</a></li>
                    </ul>
                </li>
              
                <li id="qlhoso"><a href="/quan-ly-ho-so">Quản Lý hồ sơ</a></li>
                <li class="dropdown navbar-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{!! Auth::user()['user_name'] !!}<b class="caret" ></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="/doi-mat-khau">Đổi Mật Khẩu</a></li>
                        <li><a href="/dang-xuat">Đăng xuất</a></li>
                    </ul>
                </li>
            </ul>
        </div>
      <div>
                 @yield('content')
           </div>

    </div>
   
</body>
</html>
