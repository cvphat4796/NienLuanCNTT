 $(function(){
 	var data1 = "";

   

 	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

    submitNganhExcel = function () {
        var extension = $('#nganhfiles').val().split('.').pop().toLowerCase();
        if ($.inArray(extension, ['csv', 'xls', 'xlsx']) == -1) {
            alert('Vui lòng chọn file Excel!!!');
            return false;

        }
        $('#proDialog').modal({
                                backdrop: 'static',
                                keyboard: false  // to prevent closing with Esc button (if you want this too)
                            });

        var file_data = $('#nganhfiles').prop('files')[0];
        var form_data = new FormData();
        form_data.append('fileNganh', file_data);
        $.ajax({
            url: '/them-nganh-excel',
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

    removeCN = function (id) {
        $("#cn_"+id).remove();
        $("#btn"+id).remove();
        arrIDCN = arrIDCN.filter(item => item != id)
    }

    var indexCN = 0;
    var arrIDCN = [];   
    addCN = function (value="") {
        $('#cn_ten').append('<input class="form-control pull-left" id=cn_'+indexCN+
                            ' style="width: 85%"  placeholder="Tên chuyên ngành" value="'
                            +value+'" type="text"/>'+
                            '<button type="button" class="btn btn-danger" id=btn'+indexCN+' onclick="removeCN(\''+indexCN+'\')"'+
                            ' ><i class="glyphicon glyphicon-minus"></i></button>');
        arrIDCN.push(indexCN);
        indexCN++;
    }

 	submitNganh = function(event) {

            var cn = new Array();
            for (var i = 0; i < arrIDCN.length; i++) {
                if($('#cn_'+arrIDCN[i]).val() != '')
                    cn[i] = $('#cn_'+arrIDCN[i]).val();
            }
            
            var nganh_id = $('#nganh-id').val();    
            var nganh_maso = $('#nganh-maso').val();
            var nganh_ten = $('#nganh-ten').val();
            var nganh_chitieu = $('#nganh-chitieu').val();
            var bh = $('#bh').val();
            var nganh_diemchuan = $('#nganh-diemchuan').val();
            
            var querry = $('#querry').val();
            
        if(querry == 'insert' || querry == 'update'){
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
             var khoi = [];
                $(':checkbox:checked').each(function(i){
                  khoi[i] = $(this).val();
                });
            if($.isEmptyObject(khoi)){
                     alert('Phải chọn khối xét tuyển!!');          
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
                    cn: cn,
                    querry: querry},
 			success: function (response) {
 				alert(response.message);
                if (response.status) {
                    $('#tableNganh').DataTable().ajax.reload();      
                   // $('#modalNganh').modal('hide');
                }
 				
 			}
 		});
 		
 	};

 	$(document).ready(function($) {
 		tableNganh();
        $('#tableNganh_paginate').addClass('dbtb_paginate');
        $('#tableNganh_length').addClass('dbtb_length');

        $('#btnNganhs').click(function(event) {
            $('#cn_ten').empty();
            $('#querry').val('insert');
            $('#h4-Nganh').text("Thêm Ngành");
            $('#nganh-maso').val('');
            $('#nganh-ten').val('');
            $('#nganh-chitieu').val('');
            $('#nganh-diemchuan').val('');
            $(':checkbox:checked').each(function(i){
                      $(this).prop({checked: false});
            });
            $('#modalNganh').modal('show');
        });

        $('#btnNganhExcel').click(function(event) {
            $('#modalNganhExcel').modal('show');
        });

        $('#btnDiemChuanExcel').click(function(event) {
              $('#modalDiemChuan').modal('show');
        });
 	});
 	

 	tableNganh = function () {
 		$('#tableNganh').DataTable({
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
        buttons: [ {
                        attr:{id: "btnNganhs"},
                        className: 'btn btn-info',
                        text: '<i class="glyphicon glyphicon-plus"></i>Thêm',
                    },
                    {
                        attr:{id: "btnNganhExcel"},
                        className: 'btn btn-info',
                        text: '<i class="glyphicon glyphicon-plus"></i>Thêm Với Excel',
                    },
                    {
                        attr:{id: "btnDiemChuanExcel"},
                        className: 'btn btn-info',
                        text: '<i class="glyphicon glyphicon-plus"></i>Thêm Điểm Với Excel',
                    }
                ],
 	 	aLengthMenu: [[10, 30, 50, 100, -1], [10, 30, 50, 100, "Tất cả"]],
 	 	iDisplayLength: 10,
        processing: true,
        serverSide: true,
        ajax:'/api-dc/get-list-nganh',
        columns: [
            {data: null},
            {data: 'ngh_maso'},
            {data: 'ngh_ten'},
            {data: 'tohopmon'},
            {data: 'ngh_chitieu'},
            {data: 'ngh_bachoc'},
            {data: 'action'},
        ],
          "columnDefs": [ 
         
           {
            "targets": 0,
            "data": "download_link",
            "render": function ( data, type, row, meta ) {
              return meta.row+1;
            }
          } 
          ],
       
        
    });
 	} 

    submitDiemChuan = function () {
        var extension = $('#diemchuanfiles').val().split('.').pop().toLowerCase();
        if ($.inArray(extension, ['csv', 'xls', 'xlsx']) == -1) {
            alert('Vui lòng chọn file Excel!!!');
            return false;

        }
        $('#proDialog').modal({
                                backdrop: 'static',
                                keyboard: false  // to prevent closing with Esc button (if you want this too)
                            });

        var file_data = $('#diemchuanfiles').prop('files')[0];
        var form_data = new FormData();
        form_data.append('diemchuan', file_data);
        $.ajax({
            url: '/them-diem-chuan-excel',
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
        $('#cn_ten').empty();
        $('#nganh-maso').val($('#'+button.id).data('maso'));
        ten = $('#'+button.id).data('ten')
        tenN = ten.split(":");
        $('#nganh-ten').val(tenN[0]);
        if(tenN.length > 1){
            tenCN = tenN[1].split(',');
            for (var i = 0; i < tenCN.length;i++) {
               addCN(tenCN[i]);
            }
        }
        

        $('#nganh-chitieu').val($('#'+button.id).data('chitieu'));
        $('#nganh-id').val($('#'+button.id).data('id'));
        $('#nganh-diemchuan').val($('#'+button.id).data('ngh_diemchuan'));
        
        $('#bh').val($('#'+button.id).data('bachoc')=="Đại Học"?"DH":"CD");
        var kh = $('#'+button.id).data('thm_maso').split(':');
        for (var i = 0; i < kh.length-1; i++) {
            $('#'+kh[i]).prop({checked: true})
        }
 		$('#querry').val('update');
 		$('#modalNganh').modal('show');
 	}

 	deleteNganh = function (button) {
         tenN = $('#'+button.id).data('ten').split(':');
 		ok = confirm("Bạn muốn xóa ngành: "+tenN[0]+"?");
 		if(ok){

 			$('#nganh-id').val($('#'+button.id).data('id'));
 			$('#querry').val('delete');
 			submitNganh();
 		}
 		
 	}

 });