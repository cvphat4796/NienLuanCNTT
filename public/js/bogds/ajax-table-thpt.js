$(function () {
	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

	$(document).ready(function($) {
 		tableTHPT();
        $('#tableTHPT_paginate').addClass('dbtb_paginate');
        $('#tableTHPT_length').addClass('dbtb_length');
 	});
 	


 	tableTHPT = function () {
 		$('#tableTHPT').DataTable({
 		 "dom": '<"text-right"f>rt<lp><"clear">',
         responsive: true,

 	 	"language": {
            "search": "Tìm kiếm:",
            "processing":     "Đang xử lý...",
            "lengthMenu": "Hiện _MENU_ dòng",
            "zeroRecords": "Không tìm thấy!",
            "info": "Hiện _PAGE_ của _PAGES_",
            "infoEmpty": "Không có dữ liệu",
            "infoFiltered": "(Lọc từ _MAX_ total dòng)",
            
        },
 	 	aLengthMenu: [[10, 50, 100, -1], [10, 50, 100, "Tất cả"]],
 	 	iDisplayLength: 10,
        processing: true,
        serverSide: true,
        columns:[ {   // Responsive control column
                data: null,
                defaultContent: '',
                className: 'control',
                orderable: false
            }, 
                {data: 'user_id'},
                {data: 'user_id'},
                {data: 'user_name'},
                {data: 'user_addr'},
                {data: 'user_phone'},
                {data: 'user_email'},
                {data: 'ten_sgd'},
                {data: 'action', name: 'action', orderable: false, searchable: false}],
        ajax:{
        	url:'/bo-giao-duc/get-list-thpt',
        	type: 'GET'},
        "columnDefs": [ 
	               {
	                "targets": 1,
	                "data": null,
                     className: 'stt',
	                "render": function ( data, type, row, meta ) {
	                  return meta.row+1;
	                }
	              } 
	    ],
	    initComplete: function () {
            this.api().columns([2, 6]).every( function () {
                var column = this;
                var select = $('<select class="form-control" ><option value="">Hiện Tất Cả</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                  select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        },
    });
 	} 


 	submitTHPT = function(event) {
        var thpt_maso = $('#thpt-maso').val();
        var thpt_ten = $('#thpt-ten').val();
        var thpt_diachi = $('#thpt-diachi').val();
        var thpt_sdt = $('#thpt-sdt').val();
        var thpt_email = $('#thpt-email').val();
        var thpt_sgd = $('#sogd').val();
        var querry = $('#querry').val();
        if(querry=="update"){
            if(thpt_ten == ''){
                alert('Phải nhập tên trường THPT!!');
                return false;
            }
         
            if(thpt_diachi == ''){
                alert('Phải nhập địa chỉ trường THPT!!');
                return false;
            }
            if(thpt_sdt == ''){
                alert('Phải nhập só điện thoại trường THPT!!');
                return false;
            }
        }  
 		$.ajax({
 			url: '/so-giao-duc/them-thpt',
 			type: 'POST',
 			data: {thpt_maso: thpt_maso, 
                    thpt_ten: thpt_ten,
                    thpt_diachi: thpt_diachi,
                    thpt_sdt: thpt_sdt,
                    thpt_email: thpt_email,
                    thpt_sgd: thpt_sgd, 
                    querry: querry},
 			success: function (response) {
 				alert(response.message);
                if (response.status) {
                	$('#modalTHPT').modal('hide');
                    $('#tableTHPT').DataTable().ajax.reload()
                }
 				
 			}
 		});
 		
 	};
 	
 	editthpt = function (button) {
 		$('#thpt-maso').prop('readonly', true);
        $('#h4-THPT').text("Sửa Trường THPT");
        $('#thpt-maso').val($('#'+button.id).data('mathpt'));
        $('#thpt-ten').val($('#'+button.id).data('tenthpt'));
        $('#thpt-diachi').val($('#'+button.id).data('dcthpt'));
        $('#thpt-sdt').val($('#'+button.id).data('sdtthpt'));
        $('#thpt-email').val($('#'+button.id).data('emailthpt'));
 		$('#sogd').val($('#'+button.id).data('idsgd'))
 		$('#querry').val('update');
 		$('#modalTHPT').modal('show');
 	}

 	deletethpt = function (button) {
 		ok = confirm("Bạn muốn xóa môn "+$('#'+button.id).data('tenthpt')+"?");
 		if(ok){
 			$('#thpt-maso').val($('#'+button.id).data('mathpt'));
            $('#thpt-ten').val($('#'+button.id).data('tenthpt'));
 			$('#querry').val('delete');
 			submitTHPT();
 		}
 		
 	}
});