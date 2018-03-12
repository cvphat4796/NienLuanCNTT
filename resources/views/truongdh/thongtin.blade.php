@extends('layouts.dhlayout')
@section('title','Thông Tin Trương Đại Học')
@section('content')
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-push-3 col-md-6 col-lg-6">
			<table class="table table-hover table-striped table-bordered">
				<thead>
					<tr >
						<th colspan="2" style="text-align: center;">Thông Tin</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Mã Số:</td>
						<td>{!! Auth::user()['user_id'] !!}</td>
					</tr>
					<tr>
						<td>Tên:</td>
						<td>{!! Auth::user()['user_name'] !!}</td>
					</tr>
					<tr>
						<td>Địa chỉ:</td>
						<td>{!! Auth::user()['user_addr'] !!}</td>
					</tr>
					<tr>
						<td>Số điện thoại:</td>
						<td>{!! Auth::user()['user_phone'] !!}</td>
					</tr>
					<tr>
						<td>Email:</td>
						<td>{!! Auth::user()['user_email'] !!}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@endsection