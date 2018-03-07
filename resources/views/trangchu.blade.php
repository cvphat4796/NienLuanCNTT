@extends('layouts.layout')
@section('title','Trang Chủ')
@section('content')
<div class="row">
    		<div class="col-xs-4 col-xs-push-1 col-sm-9 col-sm-push-2 col-md-6 col-md-push-3 col-lg-5 col-lg-push-4 ">
    			<form class="navbar-form navbar-left timkiem" role="search">
    				<div class="form-group ">
    					<label for="timkiem">Nhập SBD:</label>
    					<input type="text" class="form-control" placeholder="Nhập số báo danh">
    				</div>
    				<button type="submit" class="btn btn-default">Tìm Kiếm</button>
    			</form>
    						
    		</div>
    	</div>


<script>
        $(document).ready(function () {
            $('#trangchu').addClass('active');
        });

</script>

@endsection()