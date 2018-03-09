@extends('layouts.bgdlayout')
@section('title')
{{ $title }}
@endsection
@section('content')

 <div class="row">
      <div class="col-xs-6  col-md-push-2 col-sm-6 col-md-6 col-lg-6">
         <div class="class-btn text-left">
            <button id="myBtn"  data-toggle="modal" data-target="#myModal">edit</button>
            <button>delete</button>
          </div>  
      </div>
     <div class="col-xs-6 col-md-pull-2 col-sm-6 col-md-6 col-lg-6">
       <div class="search text-right">
          <span>Search:</span>
         <input type="text" >
       </div>
     </div>
    </div>

 <div class="row">
 	<div class="col-xs-8 col-md-push-2 col-sm-8  col-md-8  col-lg-8 ">
 		<table class="table table-hover table-striped">
 			<thead>
 				<tr>
 					<th>Mã Số</th>
 					<th>Tên</th>
          <th>Địa Chỉ</th>
          <th>Số Điện Thoại</th>
          <th>Email</th>
 				</tr>
 			</thead>
 			<tbody>
 				@foreach ($dss as $ds)
				  	<tr>
   						<td> {{ $ds->user_id }} </td>
              <td> {{ $ds->user_name }} </td>
              <td> {{ $ds->user_addr }} </td>
              <td> {{ $ds->user_phone }} </td>
   						<td> {{ $ds->user_email }} </td>
   					</tr>
				@endforeach
 				
 			</tbody>
 		</table>
		<div class="text-center">
			{!! $dss->links() !!}
		</div>
			
 	</div>
 </div>

 <script>
        $(document).ready(function () {
            $('#qltaikhoan').addClass('active');
        });

</script>


@endsection()