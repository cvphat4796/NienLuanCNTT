 $(function(){
 	var data1 = "";

    $('#showDialogHS').click(function(event) {
        $('#querry').val('insert');
        $('#h4-hs').text("Thêm Trường HS");
        $('#hs-maso').val('');
        $('#hs-ten').val('');
        $('#hs-pass1').removeClass('hidden');
        $('#hs-pass2').removeClass('hidden');
        $('#lb-mk1').removeClass('hidden');
        $('#lb-mk2').removeClass('hidden');
        $('#hs-diachi').val('');
        $('#hs-sdt').val('');
        $('#hs-email').val('');
        $('#hs-cmnd').val('');
        $('#hs-ngaysinh').val('');

        $('#thpt').val('');
        $('#kv_maso').val('');
        $('#gioitinh').val('nam');
        
    });

 	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

    submitExcelHS = function () {
        var extension = $('#hsfile').val().split('.').pop().toLowerCase();
        if ($.inArray(extension, ['csv', 'xls', 'xlsx']) == -1) {
            alert('Vui lòng chọn file Excel!!!');
            return false;

        }
        $('#proDialog').modal({
                                backdrop: 'static',
                                keyboard: false  // to prevent closing with Esc button (if you want this too)
                            });

        var file_data = $('#hsfile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('hs', file_data);
        $.ajax({
            url: '/tao-tai-khoan-excel',
            type: 'POST',
            data: form_data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            complete: function() {
                $('#proDialog').modal('hide');
            },
            success: function (response) {
                $('#proDialog').modal('hide');
                alert(response.message);
                if (response.status) {
                    $('#tableHS').DataTable().ajax.reload()
                }
                
            }
        });

       
    }

 	submitHS = function(event) {
        var hs_maso = $('#hs-maso').val();
        var hs_ten = $('#hs-ten').val();
        var hs_pass1 = $('#hs-pass1').val();
        var hs_pass2 = $('#hs-pass2').val();
        var hs_diachi = $('#hs-diachi').val();
        var hs_sdt = $('#hs-sdt').val();
        var hs_email = $('#hs-email').val();
        var hs_thpt = $('#thpt').val();
        var hs_kv = $('#kv_maso').val();
        var hs_gioitinh = $('#gioitinh').val();
        var hs_ngaysinh = $('#hs-ngaysinh').val();
        var hs_cmnd = $('#hs-cmnd').val();
        var querry = $('#querry').val();

        if(querry == 'insert'){
            if(hs_maso == ''){
                alert('Phải nhập mã trường Học Sinh!!');          
                return false;
            }
            if(hs_ten == ''){
                alert('Phải nhập tên trường Học Sinh!!');
                return false;
            }
            if(hs_pass1 == ''){
                alert('Phải nhập mật khẩu trường Học Sinh!!');
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
            if(hs_thpt == '' || hs_thpt == null){
                alert('Phải chọn trường THPT cho học sinh!!');
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
            if(hs_pass1 != hs_pass2 ){
                alert('Mật khẩu nhập lại không đúng!!');
                return false;
            }  
        } 
        
 		$.ajax({
 			url: '/so-giao-duc/them-hs',
 			type: 'POST',
 			data: {hs_maso: hs_maso, 
                    hs_ten: hs_ten,
                    hs_pass: hs_pass1,
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
 	 	aLengthMenu: [[3, 5, 10, -1], [3, 5, 10, "Tất cả"]],
 	 	iDisplayLength: 3,
        processing: true,
        serverSide: true,
        columns:[
                {data: 'user_id'},
                {data: 'user_name'},
                {data: 'user_phone'},
                {data: 'hs_gioitinh'},
                {data: 'hs_cmnd'},
                {data: 'hs_ngaysinh'},
                {data: 'user_addr'},
                {data: 'thpt_maso'},
                {data: 'action', name: 'action', orderable: false, searchable: false}],
        ajax:'/so-giao-duc/get-list-hs',
        columnDefs: [ {
                      targets: 5,
                      render: $.fn.dataTable.render.moment(  'DD/MM/YYYY' )
                    } ],
        
    });
 	} 

 	
 	ediths = function (button) {
        $('#h4-HS').text("Sửa Thông Tin Học Sinh");
        $('#hs-maso').val($('#'+button.id).data('mahs'));
        $('#hs-ten').val($('#'+button.id).data('tenhs'));
        $('#hs-pass1').addClass('hidden');
        $('#hs-pass2').addClass('hidden');
        $('#lb-mk1').addClass('hidden');
        $('#lb-mk2').addClass('hidden');
        $('#hs-diachi').val($('#'+button.id).data('dchs'));
        $('#hs-sdt').val($('#'+button.id).data('sdths'));
        $('#hs-email').val($('#'+button.id).data('emailhs'));
 		$('#hs-cmnd').val($('#'+button.id).data('cmnd'));
        $('#hs-ngaysinh').val(moment($('#'+button.id).data('ngaysinh')).format("DD/MM/YYYY"));

        $('#thpt').val($('#'+button.id).data('thpt'));
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