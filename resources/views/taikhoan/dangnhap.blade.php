@extends('layouts.layout')
@section('title','Đăng Nhập')
@section('content')

<div class="jumbotron text-center">
    <div class="row">
        <div class="col-lg-12">
                <div class="modal-dialog">
                    <div class="loginmodal-container">
                      <h1>Đăng Nhập</h1><br>
                      <form action="/dang-nhap" method="post">
                         {{ csrf_field() }}
                        <input type="text" name="user" placeholder="Tên đăng nhập">
                        <input type="password" name="pass" placeholder="Mật khẩu">
                        <input type="submit" name="Login" class="login loginmodal-submit" value="Đăng nhập">
                      </form>
                      
                     {{--  <div class="login-help">
                        <a href="#">Register</a> - <a href="#">Forgot Password</a>
                      </div> --}}
                    </div>
              </div>
        </div>
        
    </div>

</div>

@endsection()