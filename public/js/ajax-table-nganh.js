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
                    $('#tableNganh').DataTable().ajax.reload()
                }
                
            }
        });

       
    }

 	submitNganh = function(event) {
                
            var nganh_maso = $('#nganh-maso').val();
            var nganh_ten = $('#nganh-ten').val();
            var nganh_chitieu = $('#nganh-chitieu').val();
            var bh = $('#bh').val();
            var querry = $('#querry').val();
            var khoi = [];
                $(':checkbox:checked').each(function(i){
                  khoi[i] = $(this).val();
                });
            if($.isEmptyObject(khoi)){
                     alert('Phải chọn khối xét tuyển!!');          
                    return false;
            }
        if(querry == 'insert'){
            if(nganh_maso == ''){
                alert('Phải nhập mã ngành!!');          
                return false;
            }
            if(nganh_ten == ''){
                alert('Phải nhập tên ngành!!');
                return false;
            }
            if(nganh_chitieu == ''){
                alert('Phải nhập chỉ tiêu!!');
                return false;
            }
            if(bh == '' || bh == null){
                alert('Phải chọn bậc học!!');
                return false;
            }
             
        } 
        
 		$.ajax({
 			url: '/dai-hoc/them-nganh',
 			type: 'POST',
 			data: {nganh_maso: nganh_maso, 
                    nganh_ten: nganh_ten,
                    nganh_chitieu: nganh_chitieu,
                    bh: bh,
                    khoi: khoi,
                    querry: querry},
 			success: function (response) {
 				alert(response.message);
                if (response.status) {
                    $('#tableNganh').DataTable().ajax.reload()
                }
 				
 			}
 		});
 		
 	};

 	$(document).ready(function($) {
 		tableNganh();
        $('#tableHS_paginate').addClass('dbtb_paginate');
        $('#tableHS_length').addClass('dbtb_length');
 	});
 	

 	tableNganh = function () {
 		$('#tableNganh').DataTable({
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
        ajax:'/dai-hoc/get-list-nganh',
        columns: [
            {data: 0},
            {data: 1},
            {data: 4},
            {data: 2},
            {data: 3},
        ],
         "columnDefs": [ {
            "targets": 4,
            "data": "download_link",
            "render": function ( data, type, row, meta ) {
              return '<button onclick="editCTK(this)" '
                    +'data-makhoi="'+row[6]+'"'
                    +'data-mon1="'+row[4]+'"'
                    +'data-mon2="'+row[2]+'"'
                    +'data-mon3="'+row[0]+'"'
                    +'id="editKN-'+row[6]+'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Sửa</button>'
                    
                    +'<button onclick="deleteCTK(this)"'
                    +'data-tenkhoi="'+row[7]+'"'
                    +'data-makhoi="'+row[6]+'"'
                    +'data-mon1="'+row[4]+'"'
                    +'data-mon2="'+row[2]+'"'
                    +'data-mon3="'+row[0]+'"'
                    +'id="deleteKN-'+row[6]+'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-trash"></i> Xóa</button> ';
            }
          } ],
       
        
    });
 	} 

    submitDiemExcelHS = function () {
        var extension = $('#hsDiemfile').val().split('.').pop().toLowerCase();
        if ($.inArray(extension, ['csv', 'xls', 'xlsx']) == -1) {
            alert('Vui lòng chọn file Excel!!!');
            return false;

        }
        $('#proDialog').modal({
                                backdrop: 'static',
                                keyboard: false  // to prevent closing with Esc button (if you want this too)
                            });

        var file_data = $('#hsDiemfile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('diemhs', file_data);
        $.ajax({
            url: '/so-giao-duc/them-diem-excel',
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
               
                
            }
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