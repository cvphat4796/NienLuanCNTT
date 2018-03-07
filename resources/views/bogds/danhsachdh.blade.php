@extends('layouts.bgdlayout')
@section('title','Danh Sách Trường Đại Học')
@section('content')

 <div class="row">
 	<div class="col-xs-4 col-md-push-4 col-sm-4  col-md-4  col-lg-4 ">
 		<table class="table table-hover">
 			<thead>
 				<tr>
 					<th>Mã Số</th>
 					<th>Tên</th>
 				</tr>
 			</thead>
 			<tbody>
 				@foreach ($dhs as $dh)
				  	<tr>
 						<td> {{ $dh->user_id }} </td>
 						<td> {{ $dh->user_name }} </td>
 					</tr>
				@endforeach
 				
 			</tbody>
 		</table>

			{!! $dhs->links() !!}
 	</div>
 </div>

 <script>
        $(document).ready(function () {
            $('#qltaikhoan').addClass('active');
        });

</script>


@endsection()