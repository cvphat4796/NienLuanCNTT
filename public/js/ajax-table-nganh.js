 $(function(){
 	var data1 = "";

    $('#showDialogNganh').click(function(event) {
        $('#querry').val('insert');
        $('#h4-Nganh').text("Thêm Ngành");
        $('#nganh-maso').val('');
        $('#nganh-ten').val('');
        $('#nganh-chitieu').val('');
       $('#nganh-diemchuan').val('');
        $(':checkbox:checked').each(function(i){
                  $(this).prop({checked: false});
        });
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
            var nganh_id = $('#nganh-id').val();    
            var nganh_maso = $('#nganh-maso').val();
            var nganh_ten = $('#nganh-ten').val();
            var nganh_chitieu = $('#nganh-chitieu').val();
            var bh = $('#bh').val();
            var nganh_diemchuan = $('#nganh-diemchuan').val();
            
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
 			data: {nganh_id: nganh_id,
                    nganh_maso: nganh_maso, 
                    nganh_ten: nganh_ten,
                    nganh_chitieu: nganh_chitieu,
                    nganh_diemchuan: nganh_diemchuan,
                    bh: bh,
                    khoi: khoi,
                    querry: querry},
 			success: function (response) {
 				alert(response.message);
                if (response.status) {
                    $('#tableNganh').DataTable().ajax.reload();      
                    $('#modalNganh').modal('hide');
                }
 				
 			}
 		});
 		
 	};

 	$(document).ready(function($) {
 		tableNganh();
        $('#tableNganh_paginate').addClass('dbtb_paginate');
        $('#tableNganh_length').addClass('dbtb_length');
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
            {data: 1},
            {data: 2},
            {data: 5},
            {data: 3},
            {data: 4},
        ],
         "columnDefs": [ {
            "targets": 5,
            "data": "download_link",
            "render": function ( data, type, row, meta ) {
              return '<button onclick="editNganh(this)" '
                    +'data-idnganh="'+row[0]+'"'
                    +'data-manganh="'+row[1]+'"'
                    +'data-bh="'+row[4]+'"'
                    +'data-tennganh="'+row[2]+'"'
                    +'data-tohopmon="'+row[6]+'"'
                    +'data-chitieu="'+row[3]+'"'
                    +'data-diemchuan="'+row[7]+'"'
                    +'id="editNganh-'+row[0]+'"' 
                    +' class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Sửa</button>'

                    +'<button onclick="deleteNganh(this)"'
                    +'data-idnganh="'+row[0]+'"'
                    +'data-tennganh="'+row[2]+'"'
                    +'id="deleteNganh-'+row[0]+'"'
                    +' class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-trash"></i> Xóa</button> ';
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
 	
 	editNganh = function (button) {
        $('#h4-Nganh').text("Sửa Thông Tin Ngành");

        $('#nganh-maso').val($('#'+button.id).data('manganh'));
        $('#nganh-ten').val($('#'+button.id).data('tennganh'));
        $('#nganh-chitieu').val($('#'+button.id).data('chitieu'));
        $('#nganh-id').val($('#'+button.id).data('idnganh'));
        $('#nganh-diemchuan').val($('#'+button.id).data('diemchuan'));
        
        $('#bh').val($('#'+button.id).data('bh')=="Đại Học"?"DH":"CD");
        var kh = $('#'+button.id).data('tohopmon').split(':');
        for (var i = 0; i < kh.length-1; i++) {
            $('#'+kh[i]).prop({checked: true})
        }
 		$('#querry').val('update');
 		$('#modalNganh').modal('show');
 	}

 	deleteNganh = function (button) {
 		ok = confirm("Bạn muốn xóa ngành "+$('#'+button.id).data('tennganh')+"?");
 		if(ok){
 			$('#nganh-id').val($('#'+button.id).data('idnganh'));
 			$('#querry').val('delete');
 			submitHS();
 		}
 		
 	}

 });