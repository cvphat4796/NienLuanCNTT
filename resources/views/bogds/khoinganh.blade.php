@extends('layouts.bgdlayout')
@section('title','Quản lý khối ngành')
@section('content')
<div class="row">
	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">

		<form action="them-mon-hoc" method="post">
			{{ csrf_field() }}
			<div class="panel panel-default">
				<div class="panel-heading text-center">
					Thêm Môn Học
				</div>
				<div class="panel-body">
					<div class="form-group">
                                <label for="textbox1">*Mã số:</label>
                                <input class="form-control" name="maso" placeholder="Nhập mã số" type="text"/>

                                <label for="textbox2">*Tên:</label>
                                <input class="form-control" name="ten" placeholder="Nhập tên" type="text"/>
                    </div>
					<div class="text-right">
                                <input type="submit" value="Cập Nhật" class="btn btn-default">                  
                    </div>
				</div>
			</div>
		</form>

		<div >
			
		
			<table id="myTable" class="table table-fixedheader">
	 			<thead>
	 				<tr>
	 					<th>Mã Số</th>
	 					<th>Tên</th>
	          
	 				</tr>
	 			</thead>
	 			<tbody >
	 				@foreach ($monhoc as $mh)	
					  	<tr>
	 						<td> {{ $mh->mh_maso }}</td>
	            			<td> {{ $mh->mh_ten }}</td>
	            
	 					</tr>
					@endforeach
	 				
	 			</tbody>
	 		</table>
	 	</div>
	</div>
</div>


<div class="container">
  <table class="table table-fixedheader">
    <thead>
      <tr>
        <th class="col-xs-3">First Name</th>
        <th class="col-xs-3">Last Name</th>
        <th class="col-xs-6">E-mail</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>

      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
      <tr>
        <td class="col-xs-3">John</td>
        <td class="col-xs-3">Doe</td>
        <td class="col-xs-6">johndoe@email.com</td>
      </tr>
    </tbody>
  </table>
</div>

<script>
        $(document).ready(function () {
            $('#qlkhoinganh').addClass('active');
        });

</script>
@endsection()