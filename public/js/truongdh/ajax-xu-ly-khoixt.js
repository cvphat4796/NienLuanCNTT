$(function () {


 	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

	$(document).ready(function($) {
 		tableMH();
        tableKhoi();
		tableKXT();
    	$('#table-kxt_paginate').addClass('dbtb_paginate');
        $('#table-kxt_length').addClass('dbtb_length');
        $('#table-khoi_paginate').addClass('dbtb_paginate');
        $('#table-khoi_length').addClass('dbtb_length');

        $('#btnKhoi').click(function(event) {
			$('#querry').val('insert');
			$('#ten').val('');
			$('#modalKhoi').modal('show');
		});

		$('#btnKXT').click(function(event) {

			$('#querry').val('insert');
		    $('#sel-khoi').find('option').remove().end();
			$.ajax({
				    url: '/api-dc/get-them-khoi-nganh',
				    type: 'POST',
				    data: {querry: $('#querry').val()},
					success: function (response) {
						if(!$.isEmptyObject(response.listKhoi)){
						    addOptionToSelect('sel-khoi',response.listKhoi,'khoi_maso','khoi_ten');
						    $('#modalKXT').modal('show');
						} 
						else{
							alert('Chưa có dữ liệu về khối!!');
						}          		
					}
			});
		});

 	});

	tableMH = function () {
		$('#table-monhoc').DataTable({
					"dom": 'rt',
		 	 		"language": {
			            "search": "Tìm kiếm:",
			            "processing":     "Đang xử lý...",
			            "lengthMenu": "Hiện _MENU_ dòng",
			            "zeroRecords": "Không tìm thấy!",
			            "info": "Hiện _PAGE_ của _PAGES_",
			            "infoEmpty": "Không có dữ liệu",
			            "infoFiltered": "(Lọc từ _MAX_ total dòng)"
			        },
			       
			        ajax:'/api-dc/get-list-mon-hoc',
			        columns:[
			        	{data: 'mh_maso'},
			        	{data: 'mh_ten'},
			        ],
					
			});
	}

	
	tableKhoi = function () {
		$('#table-khoi').DataTable({
					"dom": '<"text-right"Bf>rt<lp><"clear">',
		 	 		"language": {
			            "search": "Tìm kiếm:",
			            "processing":     "Đang xử lý...",
			            "lengthMenu": "Hiện _MENU_ dòng",
			            "zeroRecords": "Không tìm thấy!",
			            "info": "Hiện _PAGE_ của _PAGES_",
			            "infoEmpty": "Không có dữ liệu",
			            "infoFiltered": "(Lọc từ _MAX_ total dòng)"
			        },
			        buttons: [
			             {
			                attr:{id: "btnKhoi"},
			                className: 'btn btn-info',
			                text: '<i class="glyphicon glyphicon-plus"></i>Thêm',
			                
			            }
			        ],
			        aLengthMenu: [[5, 10, 20, -1], [5, 10, 20,"Tất cả"]],
 	 				iDisplayLength: 5,
			        ajax:'/api-dc/get-list-khoi',
			        columns:[
			        	{data: 'khoi_ten'},
			        	{data: 'action'},
			        ],
			        columnDefs: [ { className: "text-center", "targets": [ 1 ] }
                    ],
					
			});
	}

	editKhoi = function (button) {
		$('#ten').val($('#'+button.id).data('ten'));
		$('#querry').val('update');
		$('#ma_khoi').val($('#'+button.id).data('id'));
		$('#modalKhoi').modal('show');
	}

	deleteKhoi = function (button) {
		ok = confirm("Bạn muốn xóa Khối "+$('#'+button.id).data('ten')+"?");
 		if(ok){
 			$('#ma_khoi').val($('#'+button.id).data('id'));
 			$('#ten').val($('#'+button.id).data('ten'));
 			$('#querry').val('delete');
 			submitKhoi();
 		}
	}

	submitKhoi = function () {
		var ten = $('#ten').val();
		var querry = $('#querry').val();
		var maso = $('#ma_khoi').val();
		if(ten == ''){
			alert("Bạn Chưa Nhập Tên!!!");
			return false;
		}
		 $('#proDialog').modal('show');
		$.ajax({
            url: '/dai-hoc/them-khoi',
            type: 'POST',
            data: {querry: querry, maso: maso, ten: ten},
            success: function (response) {
                $('#proDialog').modal('hide');
                alert(response.message);
                if (response.status) {
                    $('#table-khoi').DataTable().ajax.reload()
                }
                
            },
        });

	}

	

	 addOptionToSelect = function(id,array,para1,para2) {
        temp = array[0];
        $.each(array, function (i, item) {
                $('#'+id).append($('<option>', { 
                    value: item[para1],
                    text : item[para2]
                }));            
        });
        $("#"+id).val(temp[para1]);
    }

	tableKXT = function () {
		table = $('#table-kxt').DataTable({
					"dom":  '<"text-right"Bf>rt<lp><"clear">',
		 	 		"language": {
			            "search": "Tìm kiếm:",
			            "processing":     "Đang xử lý...",
			            "lengthMenu": "Hiện _MENU_ dòng",
			            "zeroRecords": "Không tìm thấy!",
			            "info": "Hiện _PAGE_ của _PAGES_",
			            "infoEmpty": "Không có dữ liệu",
			            "infoFiltered": "(Lọc từ _MAX_ total dòng)"
			        },
			        buttons: [
			             {
			                attr:{id: "btnKXT"},
			                className: 'btn btn-primary',
			                text: '<i class="glyphicon glyphicon-plus"></i>Thêm',
			            }
			        ],
			        aLengthMenu: [[5, 10, 20, -1], [5, 10, 20,"Tất cả"]],
 	 				iDisplayLength: 5,
			        ajax:'/api-dc/get-list-khoi-xet-tuyen',
			        columns:[
			        	{data: 'khoi_ten', name: 'khoi'},
			        	{data: 'mh_ten1'},
			        	{data: 'mh_ten2'},
			        	{data: 'mh_ten3'},
			        	{data: 'action'},
			        ],
					  columnDefs: [ { width: "30px", "targets": [ 4 ] }],
			});
	}

	submitKXT = function () {
		if($('#querry').val() != 'delete')
		{
			if($('#sel-mon1').val() == $('#sel-mon2').val() || $('#sel-mon1').val() ==$('#sel-mon3').val() || $('#sel-mon2').val() == $('#sel-mon3').val()){
		 	            alert('Chọn trùng môn!');
		 	            return false;
		 	} 
		 }
		 console.log($('#sel-khoi').val());
	     $('#proDialog').modal('show');
	     $.ajax({
	            url: '/dai-hoc/them-khoi-xet-tuyen',
	            type: 'POST',
	            data: {khoi: $('#sel-khoi').val(), mon1: $('#sel-mon1').val(), mon2: $('#sel-mon2').val(), mon3: $('#sel-mon3').val(), querry: $('#querry').val()},
	            success: function (response) {
	            	 $('#proDialog').modal('hide');
	                    alert(response.message);
	                    $('#table-kxt').DataTable().ajax.reload()
	            }
	     });
	}

	editKXT = function (button) {
		$('#querry').val('update');
		$('#sel-khoi').find('option').remove().end();
		$.ajax({
				    url: '/api-dc/get-them-khoi-nganh',
				    type: 'POST',
				    data: {querry: $('#querry').val()},
					success: function (response) {
						if(!$.isEmptyObject(response.listKhoi)){
						    addOptionToSelect('sel-khoi',response.listKhoi,'khoi_maso','khoi_ten');
						    $('#sel-khoi').val($('#'+button.id).data('id'));
						}            		
					}
			});
		
		$('#sel-mon1').val($('#'+button.id).data('mon1'));
		$('#sel-mon2').val($('#'+button.id).data('mon2'));
		$('#sel-mon3').val($('#'+button.id).data('mon3'));
		$('#modalKXT').modal('show');
	}
	
	deleteKXT = function (button) {
		ok = confirm("Bạn muốn xóa Khối "+$('#'+button.id).data('ten')+"?");
 		if(ok){
 			$('#sel-khoi').append('<option selected value="'+$('#'+button.id).data('id')+'"></option>');
 			$('#querry').val('delete');
 			submitKXT();
 		}
	}
});