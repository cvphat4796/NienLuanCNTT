$(function () {

		$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

	$(document).ready(function($) {
 		tableSGDDH();
        $('#table-sgddh_paginate').addClass('dbtb_paginate');
        $('#table-sgddh_length').addClass('dbtb_length');
        
 	});
 	


 	tableSGDDH = function () {
 		var url = $(location).attr('pathname');
	    var indexsl = url.lastIndexOf('/') + 1;
	    var key = url.substring(indexsl,url.length);
		$('#table-sgddh').DataTable({
	            responsive: true,
	     		"dom": '<"text-right"f>rt<lp><"clear">',
	     	 	"language": {
	                "search": "Tìm kiếm:",
	                "processing":     "Đang xử lý...",
	                "lengthMenu": "Hiện _MENU_ dòng",
	                "zeroRecords": "Không tìm thấy!",
	                "info": "Hiện _PAGE_ của _PAGES_",
	                "infoEmpty": "Không có dữ liệu",
	                "infoFiltered": "(Lọc từ _MAX_ total dòng)"
	            },
	     	 	aLengthMenu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Tất cả"]],
	     	 	iDisplayLength: 10,
	            processing: true,
	            serverSide: true,
	            ajax:{
	                url: '/bo-giao-duc/get-list-sgd-dh',
	                type: 'POST',
	                data: {key: key}
	            },
	            columns: [
	                {data: 1},
	                {data: 0},
	                {data: 1},
	                {data: 2},
	                {data: 4},
	                {data: 3},
	                {data: 0},
	            ],
	             "columnDefs": [ 
	               {
	                "targets": 0,
	                "data": null,
	                "render": function ( data, type, row, meta ) {
	                  return meta.row+1;
	                }
	              } ,
	               {
	                "targets": 6,
	                "data": null,
	                "render": function ( data, type, row, meta ) {
	                  return '<button class="btn btn-xs btn-primary" id="edit'+row[0]+'" '
        					+ 'onclick="edit(this)" '
        					+ 'data-maso="'+row[0]+'" '
        					+ 'data-ten="'+row[1]+'" '
        					+ 'data-email="'+row[3]+'" '
        					+ 'data-sdt="'+row[4]+'" '
        					+ 'data-diachi="'+row[2]+'" > '
        					+'<i class="glyphicon glyphicon-edit"></i> Sửa </button>'
        					+ '<button class="btn btn-xs btn-danger" id="delete'+row[0]+'" '
        					+ 'onclick="deletes(this)" '
        					+ 'data-maso="'+row[0]+'" '
        					+ 'data-ten="'+row[1]+'" '
        					+'<i class="glyphicon glyphicon-edit"></i> Xóa </button>';
	                }
	              } 
	              ],
	       
	        
	    });
 	}//het js xu ly load du lieu table

 	suaSGDDH = function () {
 		
 		var ma_so = $('#ma_so').val();
 		var ten = $('#ten').val()
 		var dia_chi = $('#dia_chi').val()
 		var sdt = $('#sdt').val()
 		var email = $('#email').val()
 		var query = $('#query').val();

 		if(query=='update'){
 			if(ten =='' || dia_chi == '' || sdt == ''){
 				alert('Bận Chưa Nhập Đủ Thông Tin!!!');
 				return false;
 			}
 		}

 		$('#proDialog').modal({
                                backdrop: 'static',
                                keyboard: false  // to prevent closing with Esc button (if you want this too)
                            });

    	$.ajax({
            url: '/bo-giao-duc/sua-thong-tin',
            type: 'POST',
            data: {ma_so: ma_so, 
            		ten: ten, 
            		dia_chi: dia_chi, 
            		sdt: sdt, 
            		email: email, 
            		querry: query},
            success: function (response) {
                alert(response.message);
                if (response.status) {

                	$('#proDialog').modal('hide');
                	$('#modalSuaSGDDH').modal('hide');
                    $('#table-sgddh').DataTable().ajax.reload();
                }
                
            }
        });
 	}
 	edit = function (button) {

 		$('#ma_so').val($('#'+button.id).data('maso'))
 		$('#ten').val($('#'+button.id).data('ten'))
 		$('#dia_chi').val($('#'+button.id).data('diachi'))
 		$('#sdt').val($('#'+button.id).data('sdt'))
 		$('#email').val($('#'+button.id).data('email'))
 		$('#query').val('update');
 		$('#ma_so').prop('readonly', true);
 		$('#modalSuaSGDDH').modal('show');
 	}
	
 	deletes = function (button) {
 		ok = confirm("Bạn muốn xóa "+$('#'+button.id).data('ten')+"?");
 		if(ok){
 			$('#ma_so').val($('#'+button.id).data('maso'));
 			$('#query').val('delete');
 			suaSGDDH();
 		}
 	}
});