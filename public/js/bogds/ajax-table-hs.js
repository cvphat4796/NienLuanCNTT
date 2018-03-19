 $(function(){
 	
 	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

   

 	submitHS = function(event) {
        var hs_maso = $('#hs-maso').val();
        var hs_ten = $('#hs-ten').val();
        var hs_diachi = $('#hs-diachi').val();
        var hs_sdt = $('#hs-sdt').val();
        var hs_email = $('#hs-email').val();
        var hs_thpt = $('#thpt').val();
        var hs_kv = $('#kv_maso').val();
        var hs_gioitinh = $('#gioitinh').val();
        var hs_ngaysinh = $('#hs-ngaysinh').val();
        var hs_cmnd = $('#hs-cmnd').val();
        var querry = $('#querry').val();

        if(querry == 'update'){
            if(hs_ten == ''){
                alert('Phải nhập tên trường Học Sinh!!');
                return false;
            }
            if(hs_diachi == ''){
                alert('Phải nhập địa chỉ trường Học Sinh!!');
                return false;
            }
            if(hs_sdt == ''){
                alert('Phải nhập số điện thoại trường Học Sinh!!');
                return false;
            }
            if(hs_kv == '' || hs_kv == null){
                alert('Phải chọn khu vực cho học sinh!!');
                return false;
            }
            if(hs_ngaysinh == ''){
                alert('Phải nhập ngày sinh cho học sinh!!');
                return false;
            }
            if(hs_cmnd == '' ){
                alert('Phải số chứng minh nhân dân cho học sinh!!');
                return false;
            }
        } 
        
 		$.ajax({
 			url: '/so-giao-duc/them-hs',
 			type: 'POST',
 			data: {hs_maso: hs_maso, 
                    hs_ten: hs_ten,
                    hs_diachi: hs_diachi,
                    hs_sdt: hs_sdt,
                    hs_email: hs_email,
                    hs_thpt: hs_thpt,
                    hs_kv: hs_kv,
                    hs_gioitinh: hs_gioitinh,
                    hs_ngaysinh: hs_ngaysinh,
                    hs_cmnd: hs_cmnd, 
                    querry: querry},
 			success: function (response) {
 				alert(response.message);
                if (response.status) {
                    $('#modalHS').modal('hide');
                    $('#tableHS').DataTable().ajax.reload()
                }
 				
 			}
 		});
 		
 	};

 	$(document).ready(function($) {
 		tableHS();
        $('#tableHS_paginate').addClass('dbtb_paginate');
        $('#tableHS_length').addClass('dbtb_length');
 	});
 	

 	tableHS = function () {
 		$('#tableHS').DataTable({
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
 	 	aLengthMenu: [[10, 30, 5, 10, -1], [10, 30, 50, 100, "Tất cả"]],
 	 	iDisplayLength: 10,
        processing: true,
        serverSide: true,
        columns:[
                {data: 'user_id'},
                {data: 'user_id'},
                {data: 'user_name'},
                {data: 'user_phone'},
                {data: 'hs_gioitinh'},
                {data: 'hs_cmnd'},
                {data: 'hs_ngaysinh'},
                {data: 'user_addr'},
                {data: 'thpt_maso'},
                {data: 'action', name: 'action', orderable: false, searchable: false}],
        ajax:'/bo-giao-duc/get-list-hoc-sinh',
        columnDefs: [ {targets: 5, render: $.fn.dataTable.render.moment(  'DD/MM/YYYY' )},
                        { className: "col-name", "targets": [ 1 ] }
                    ],
        "columnDefs": [ 
                   {
                    "targets": 0,
                    "data": null,
                    "render": function ( data, type, row, meta ) {
                      return meta.row+1;
                    }
                  }
                  ],
        initComplete: function () {
            this.api().columns([4,8]).every( function () {
                var column = this;
                var select = $('<select><option value="">Hiện Tất Cả</option></select>')
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

   
 	
 	ediths = function (button) {
        $('#h4-HS').text("Sửa Thông Tin Học Sinh");
        $('#hs-maso').val($('#'+button.id).data('mahs'));
        $('#hs-ten').val($('#'+button.id).data('tenhs'));
        $('#hs-diachi').val($('#'+button.id).data('dchs'));
        $('#hs-sdt').val($('#'+button.id).data('sdths'));
        $('#hs-email').val($('#'+button.id).data('emailhs'));
 		$('#hs-cmnd').val($('#'+button.id).data('cmnd'));
        $('#hs-ngaysinh').val(moment($('#'+button.id).data('ngaysinh')).format("DD/MM/YYYY"));

       

        $('#thpt').val($('#'+button.id).data('idthpt'));
        $('#kv_maso').val($('#'+button.id).data('kvms'));
        if($('#'+button.id).data('gioitinh') == "Nam")
            $('#gioitinh').val('nam');
        else
            $('#gioitinh').val('nu');    
 		$('#querry').val('update');
 		$('#modalHS').modal('show');
 	}

 	deletehs = function (button) {
 		ok = confirm("Bạn muốn xóa môn "+$('#'+button.id).data('tenhs')+"?");
 		if(ok){
 			$('#hs-maso').val($('#'+button.id).data('mahs'));
            $('#hs-ten').val($('#'+button.id).data('tenhs'));
 			$('#querry').val('delete');
 			submitHS();
 		}
 		
 	}

   

 });