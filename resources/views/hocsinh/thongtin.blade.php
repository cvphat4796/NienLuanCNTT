@extends('layouts.hslayout')
@section('title','Thông Tin Học Sinh')
@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<table class="table table-hover table-striped table-bordered">
				<thead>
					<tr >
						
						<th colspan="2" style="text-align: center;">Thông Tin</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="col-tt">Mã Số:</td>
						<td>{!! $hocsinhs->hs_maso !!}</td>
					</tr>
					<tr>
						<td  class="col-tt">Tên:</td>
						<td>{!! $hocsinhs->user_name !!}</td>
					</tr>
					<tr>
						<td  class="col-tt">Địa chỉ:</td>
						<td>{!! $hocsinhs->user_addr !!}</td>
					</tr>
					<tr>
						<td  class="col-tt">Số điện thoại:</td>
						<td>{!! $hocsinhs->user_phone !!}</td>
					</tr>
					<tr>
						<td  class="col-tt">Email:</td>
						<td>{!! $hocsinhs->user_email !!}</td>
					</tr>
					<tr>
						<td  class="col-tt">Trường THPT:</td>
						<td>{!! $hocsinhs->thpt_ten !!}</td>
					</tr>
					<tr>
						<td  class="col-tt">Email:</td>
						<td>{!! $hocsinhs->kv_ten !!}</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
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
	</div>


 <script>
        $(document).ready(function () {
            $('#tths').addClass('active');
        });

</script>

@endsection