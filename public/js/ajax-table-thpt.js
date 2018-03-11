 $(function(){
 	var data1 = "";

    $('#showDialogTHPT').click(function(event) {
        $('#querry').val('insert');
        $('#h4-THPT').text("Thêm Trường THPT");
        $('#thpt-maso').val('');
        $('#thpt-ten').val('');
        $('#thpt-pass1').removeClass('hidden');
        $('#thpt-pass2').removeClass('hidden');
        $('#lb-mk1').removeClass('hidden');
        $('#lb-mk2').removeClass('hidden');
        $('#thpt-diachi').val('');
        $('#thpt-sdt').val('');
        $('#thpt-email').val('');
    });

 	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

    submitExcelTHPT = function () {
        var extension = $('#thptfile').val().split('.').pop().toLowerCase();
        if ($.inArray(extension, ['csv', 'xls', 'xlsx']) == -1) {
            alert('chon file khong dung dinh dang');
            return false;

        }
        $('#proDialog').modal({
                                backdrop: 'static',
                                keyboard: false  // to prevent closing with Esc button (if you want this too)
                            });

        var file_data = $('#thptfile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('thpt', file_data);
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
                    $('#tableTHPT').DataTable().ajax.reload()
                }
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                   $('#proDialog').modal({
                                show: false
                            });
                }
        });

       
    }

 	submitTHPT = function(event) {
        var thpt_maso = $('#thpt-maso').val();
        var thpt_ten = $('#thpt-ten').val();
        var thpt_pass1 = $('#thpt-pass1').val();
        var thpt_pass2 = $('#thpt-pass2').val();
        var thpt_diachi = $('#thpt-diachi').val();
        var thpt_sdt = $('#thpt-sdt').val();
        var thpt_email = $('#thpt-email').val();
        var querry = $('#querry').val();

        if(querry == 'insert'){
            if(thpt_maso == ''){
                alert('Phải nhập mã trường THPT!!');          
                return false;
            }
            if(thpt_ten == ''){
                alert('Phải nhập tên trường THPT!!');
                return false;
            }
            if(thpt_pass1 == ''){
                alert('Phải nhập mật khẩu trường THPT!!');
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
            if(thpt_pass1 != thpt_pass2 ){
                alert('Mật khẩu nhập lại không đúng!!');
                return false;
            }  
        } 
 		$.ajax({
 			url: '/so-giao-duc/them-thpt',
 			type: 'POST',
 			data: {thpt_maso: thpt_maso, 
                    thpt_ten: thpt_ten,
                    thpt_pass: thpt_pass1,
                    thpt_diachi: thpt_diachi,
                    thpt_sdt: thpt_sdt,
                    thpt_email: thpt_email, 
                    querry: querry},
 			success: function (response) {
 				alert(response.message);
                if (response.status) {
                    $('#tableTHPT').DataTable().ajax.reload()
                }
 				
 			}
 		});
 		
 	};

 	$(document).ready(function($) {
 		tableTHPT();
        $('#tableTHPT_paginate').addClass('dbtb_paginate');
        $('#tableTHPT_length').addClass('dbtb_length');
 	});
 	

 	tableTHPT = function () {
 		$('#tableTHPT').DataTable({
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
                {data: 'user_addr'},
                {data: 'user_phone'},
                {data: 'user_email'},
                {data: 'action', name: 'action', orderable: false, searchable: false}],
        ajax:'/so-giao-duc/get-list-thpt',
        
    });
 	} 

 	
 	editthpt = function (button) {
        $('#h4-THPT').text("Sửa Trường THPT");
        $('#thpt-maso').val($('#'+button.id).data('mathpt'));
        $('#thpt-ten').val($('#'+button.id).data('tenthpt'));
        $('#thpt-pass1').addClass('hidden');
        $('#thpt-pass2').addClass('hidden');
        $('#lb-mk1').addClass('hidden');
        $('#lb-mk2').addClass('hidden');
        $('#thpt-diachi').val($('#'+button.id).data('dcthpt'));
        $('#thpt-sdt').val($('#'+button.id).data('sdtthpt'));
        $('#thpt-email').val($('#'+button.id).data('emailthpt'));
 		
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