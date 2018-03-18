@extends('layouts.dhlayout')
@section('title','Danh Sách Ngành Xét Tuyển')
@section('content')

<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="{!!asset('public/js/ajax-ho-so-nop.js')!!}"></script>
<div class="row">
	
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="btnThemKhoi-MH">
		
			<label for="">Mã Ngành: </label>
			<span>{{ $ng->ngh_maso }};</span>
			<label for="">Tên Ngành: </label>
			<span>{{ $ng->ngh_ten }};</span>
			<label for="">Điểm Chuẩn: </label>
			<span>{{ $ng->ngh_chuan }};</span>
			<label for="">Chỉ Tiêu: </label>
			<span>{{ $ng->ngh_chitieu }};</span>
			<label for="">Bậc Học: </label>
			<span>{{ $ng->ngh_bachoc }}</span>
	</div>
		<div class="table-responsive">
			<table id="hoSoNop" class="table table-bordered  table-hover">
				<thead>
					<tr>
						<th>STT</th>
						<th>Mã Thí Sinh</th>
						<th>Tên Thí Sinh</th>
						<th>Số Điện Thoại</th>
						<th>Điểm Tổng</th>
						<th>Khối Xét</th>
						<th>Kết Quả</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>
@endsection