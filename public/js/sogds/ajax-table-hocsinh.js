 $(function(){
 	var data1 = "";

  

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
         $('#hs-maso').prop('readonly',false);
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
                    $('#tableHS').DataTable().draw();//ajax.reload(initCompleteFunction(settings, json),false)

                }
 				
 			}
 		});
 		
 	};

 	$(document).ready(function($) {
 		tableHS();
        $('#tableHS_paginate').addClass('dbtb_paginate');
        $('#tableHS_length').addClass('dbtb_length');
        if($('#checkThemHS').val() != 1){
               $('#btnThemHS').remove();
             $('#btnThemHSExcel').remove();
        }
        if($('#checkDiemHS').val() != 1){
          
             $('#btnThemDiemHSExcel').remove();
        }

          $('#btnThemDiemHSExcel').click(function(event) {
                 $('#modalDiemExcelHS').modal('show');
            });

        $('#btnThemHS').click(function(event) {
                    $('#querry').val('insert');
                    $('#h4-hs').text("Thêm HS");
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
                    $('#hs-maso').prop('readonly',false);
                    

                    $('#thpt').val('');
                    $('#kv_maso').val('');
                    $('#gioitinh').val('nam');
                    
                    $('#lab-cmnd').appendTo('#hs-right');   
                    $('#hs-cmnd').appendTo('#hs-right');
                    $('#lab-email').appendTo('#hs-right');   
                    $('#hs-email').appendTo('#hs-right');
                    $('#modalHS').modal('show');
            });

             $('#btnThemHSExcel').click(function(event) {
                 $('#modalExcelHS').modal('show');
             });
 	});
 	

 	tableHS = function () {
 		$('#tableHS').DataTable({
 		 "dom": '<"text-right"Bf>rt<lp><"clear">',
         responsive: true,
 	 	"language": {
            "search": "Tìm kiếm:",
            "processing":     "Đang xử lý...",
            "lengthMenu": "Hiện _MENU_ dòng",
            "zeroRecords": "Không tìm thấy!",
            "info": "Hiện _PAGE_ của _PAGES_",
            "infoEmpty": "Không có dữ liệu",
            "infoFiltered": "(Lọc từ _MAX_ total dòng)"
        },
        buttons: [{
                    attr:{id: "btnThemHS"},
                    className: 'btn btn-info',
                    text: '<i class="glyphicon glyphicon-plus"></i>Thêm',
                },
                {
                    attr:{id: "btnThemHSExcel"},
                    className: 'btn btn-info',
                    text: '<i class="glyphicon glyphicon-plus"></i>Thêm Với Excel',
                },
                {
                    attr:{id: "btnThemDiemHSExcel"},
                    className: 'btn btn-info',
                    text: '<i class="glyphicon glyphicon-plus"></i>Thêm Điểm Với Excel',
                }
                ],
 	 	aLengthMenu: [[10, 30, 50, 100, -1], [10, 30, 50, 100, "Tất cả"]],
 	 	iDisplayLength: 10,
        processing: true,
        serverSide: true,
        columns:[
                {data: null,
                    defaultContent: '',
                className: 'control',
                orderable: false
                },
                {data: 'user_id'},
                {data: 'user_name'},
                {data: 'user_phone'},
                {data: 'hs_gioitinh'},
                {data: 'hs_cmnd'},
                {data: 'hs_ngaysinh'},
                {data: 'thpt_maso'},
                {data: 'action', name: 'action', orderable: false, searchable: false}],
        ajax:'/so-giao-duc/get-list-hs',
        columnDefs: [ {targets: 6, render: $.fn.dataTable.render.moment(  'DD/MM/YYYY' )},
                        { className: "col-name", "targets": [ 2  ] },
                         { className: "text-center", "targets": [ 8 ] }
                    ],
        "drawCallback": function( settings ) {
                 initCompleteFunction(settings)
          }
        
    });
 	} 
   initCompleteFunction = function (settings) {
     console.log(settings.oInstance);
            var api =settings.oInstance.api()

            api.columns([7]).every( function () {
                var column = this;
               
                var select = $('<select class="form-control" ><option value="">Tất Cả</option></select>')
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
        $('#hs-maso').prop('readonly',true);
        $('#thpt').val($('#'+button.id).data('thpt'));
        $('#kv_maso').val($('#'+button.id).data('kvms'));
        if($('#'+button.id).data('gioitinh') == "Nam")
            $('#gioitinh').val('nam');
        else
            $('#gioitinh').val('nu'); 
        $('#lab-cmnd').appendTo('#hs-left');   
        $('#hs-cmnd').appendTo('#hs-left');
 		$('#querry').val('update');
 		$('#modalHS').modal('show');
 	}

xemthem = function (button) {
        $('#h4-HS').text("Thông Tin Học Sinh");
        $('#hs-maso').val($('#'+button.id).data('mahs'));
        $('#hs-ten').val($('#'+button.id).data('tenhs'));
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

         $('#hs-maso').prop('readonly',true);
         $('#hs-ten').prop('readonly',true);
         $('#hs-diachi').prop('readonly',true);
         $('#hs-sdt').prop('readonly',true);
         $('#hs-email').prop('readonly',true);
         $('#hs-cmnd').prop('readonly',true);
         $('#hs-ngaysinh').prop('disabled',true);
         $('#thpt').prop('disabled',true);
         $('#kv_maso').prop('disabled',true);
         $('#gioitinh').prop('disabled',true);

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
    var monhc;
    var mahs;
    nhapdiem = function (button) {
        $('#body-diem').empty();
        $('#proDialog').modal('show');
        mahs = $('#'+button.id).data('mahs');
        $.ajax({
            url: '/so-giao-duc/get-diem-hs',
            type: 'POST',
            data: {mahs: mahs},
            success: function (response) {
                $('#proDialog').modal('hide');
                monhc = response.monhoc;
                if(monhc.length > 0){
                    $('body-diem').append('<input type="hiden" id="diem-mahs" value="'+monhc[0]["hs_maso"])+'"/>';
                    for (var i = 0; i < monhc.length; i++) {
                        $('#body-diem').append( 
                        '<label for="">'+monhc[i]["mh_ten"]+': </label>'+
                        '<input type="number" id="'+monhc[i]["mh_maso"]+'" value="'+monhc[i]["dt_diemso"]+'" class="form-control">' );
                    }
                    
                    $('#proDialog').modal('hide');
                    $('#modalDiemHS').modal('show');
                }
                else{
                    alert("Chưa Nhập Điểm Cho Học Sinh Này!");
                }
            }
        });
    }

    xemdiem = function (button) {
        $('#body-diem').empty();
        $('#proDialog').modal('show');
        mahs = $('#'+button.id).data('mahs');
        $.ajax({
            url: '/so-giao-duc/get-diem-hs',
            type: 'POST',
            data: {mahs: mahs},
            success: function (response) {
                $('#proDialog').modal('hide');
                monhc = response.monhoc;
                if(monhc.length > 0){
                    $('body-diem').append('<input type="hiden" readonly id="diem-mahs" value="'+monhc[0]["hs_maso"])+'"/>';
                    for (var i = 0; i < monhc.length; i++) {
                        $('#body-diem').append( 
                        '<label for="">'+monhc[i]["mh_ten"]+': </label>'+
                        '<input type="number" readonly id="'+monhc[i]["mh_maso"]+'" value="'+monhc[i]["dt_diemso"]+'" class="form-control">' );
                    }
                    
                    $('#proDialog').modal('hide');
                    $('#modalDiemHS').modal('show');
                }
                else{
                    alert("Chưa Nhập Điểm Cho Học Sinh Này!");
                }
            }
        });
    }


    submitDiemHS = function () {
         var arrayDiem = {};
         for (var i = 0; i < monhc.length; i++) {
            arrayDiem[monhc[i]["mh_maso"]]= ( $('#'+monhc[i]["mh_maso"]).val());
        }
        
        var adiem = JSON.stringify(arrayDiem);

       $.ajax({
            url: '/so-giao-duc/sua-diem',
            type: 'POST',
            data: {hs_maso: mahs,arrayDiem: arrayDiem},
           dataType: 'JSON',
            complete: function() {
                $('#proDialog').modal('hide');
            },
            success: function (response) {
                $('#proDialog').modal('hide');
                alert(response.message);
               
                
            }
        });
    }

 });