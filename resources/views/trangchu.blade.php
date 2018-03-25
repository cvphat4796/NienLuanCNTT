@extends('layouts.layout')
@section('title','Trang Chủ')
@section('content')
<div class="row">
     @if (isset($diem))
        <div class="col-xs-12 col-sm-12 col-md-push-3 col-md-6 col-lg-6">
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan="{{count($diem)}}" style="text-align: center;">Bảng Điểm</th>
                    </tr>
                    <tr>
                    @forelse  ($diem as $d)
                        <th>{{ $d->mh_ten }}</th>

                    @endforeach 
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        
                    @forelse ($diem as $d)
                            <td>{!! $d->dt_diemso !!}</td>
                    @empty
                       <td style="text-align: center; font-weight: bold;">Hiện Tại Chưa Có Điểm</td>
                            
                        
                    @endforelse
                    </tr>

                </tbody>
            </table>
        </div>

    @else
    	<div class="col-xs-4 col-xs-push-1 col-sm-9 col-sm-push-2 col-md-6 col-md-push-3 col-lg-5 col-lg-push-4 ">
    		<form method="post" action="/tra-diem" class="navbar-form navbar-left timkiem" role="search">
                    {{ csrf_field() }}
    			<div class="form-group ">
    					<label for="timkiem">Tra Điểm:</label>
    					<input type="text" name="sbd" class="form-control" placeholder="Nhập số báo danh">
    			</div>
    			<button type="submit" class="btn btn-default">Tìm Kiếm</button>
    		</form>				
    	</div>
    @endif
</div>


<script>
        $(document).ready(function () {
            $('#trangchu').addClass('active');
        });

</script>

@endsection()