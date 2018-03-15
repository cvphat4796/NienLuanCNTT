 $(function(){
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

    

 	submitNopHS = function(event) {
            var id_nganh = $('#ma-nganh').val();
            var nguyen_vong = $('#nguyen-vong').val();    
            var khoi = $('#khoi').val();
            var querry = $('#query').val();
          
        if(querry == 'insert'){
            if(nguyen_vong == ''){
                alert('Phải nhập nguyện vọng!!');          
                return false;
            }
            
        } 
        
 		$.ajax({
 			url: '/hoc-sinh/nop-ho-so',
 			type: 'POST',
 			data: {id_nganh: id_nganh,
                    nguyen_vong: nguyen_vong,
                    khoi: khoi, 
                    querry: querry},
 			success: function (response) {
 				alert(response.message);
                if (response.status) {
                    $('#tableNganhHS').DataTable().ajax.reload(); 
                    $('#modalNopHS').modal('hide');
                }
 				
 			}
 		});		
 	};

 	$(document).ready(function($) {
        tableNganhHS();
        $('#tableNganhHS_paginate').addClass('dbtb_paginate');
        $('#tableNganhHS_length').addClass('dbtb_length');
 	});
   
 	tableNganhHS = function () {
 		table = $('#tableNganhHS').DataTable({
 		 "dom": 'B<"text-right"f>rt<lp><"clear">',
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
                text: 'Theem xxx',
                action: function ( e, dt, node, config ) {
                   $('#proDialog').modal('show');
                }
            },
             {
                attr:{id: "them"},
                text: 'Theem aaa',
                action: function ( e, dt, node, config ) {
                   $('#proDialog').modal('show');
                }
            }
        ],
 	 	aLengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tất cả"]],
 	 	iDisplayLength: 10, 
        processing: true,
        ajax:{
        url: '/hoc-sinh/get-list-nganh',
        dataSrc: 'data'
    },
         columns: [
           {data: 1},
            {data: 2},
            {data: 5},
            {data: 3},
            {data: 7},
            {data: 4},
            {data: 8},
        ],
        initComplete: function () {
            this.api().columns([0, 1, 2, 3, 4, 5, 6]).every( function () {
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
         "columnDefs": [ {
            "targets": 7    ,
            "render": function ( data, type, row, meta ) {
                if(row[9] == 0){
                     return '<button onclick="nopNganh(this)" '
                    +'data-idnganh="'+row[0]+'"'
                    +'data-manganh="'+row[1]+'"'
                    +'data-tennganh="'+row[2]+'"'
                    +'data-tohopmon="'+row[6]+'"'
                    +'id="nopNganh-'+row[0]+'"' 
                    +' class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Nộp Hồ Sơ</button>'
                }
                 else{
                     return '<button onclick="suaNganh(this)" '
                    +'data-idnganh="'+row[0]+'"'
                    +'data-tennganh="'+row[2]+'"'
                    +'data-tohopmon="'+row[6]+'"'
                    +'data-khoi="'+row[11]+'"'
                    +'data-nv="'+row[10]+'"'
                    +'id="suaNganh-'+row[0]+'"' 
                    +' class="btn btn-xs btn-success"><i class="glyphicon glyphicon-pencil"></i> Sửa Hồ Sơ</button>'
                    +'<br/>'
                    + '<button onclick="rutNganh(this)" '
                    +'data-idnganh="'+row[0]+'"'
                    +'data-tennganh="'+row[2]+'"'
                    +'id="rutNganh-'+row[0]+'"' 
                    +' class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Rút Hồ Sơ</button>'

                 }  
            }
        }],
    });
         
 } 
 	
 	nopNganh = function (button) {

        $('#khoi').empty();

        var thm = $('#'+button.id).data('tohopmon').split(':');
        $('#ma-nganh').val($('#'+button.id).data('idnganh'));
        $('#nguyen-vong').val('');
        $('#h4-nophs').text("Bạn Chọn Ngành: "+$('#'+button.id).data('tennganh'));
        for (var i = 0; i < thm.length-1; i++) {
            $('#khoi').append('<option value="'+thm[i]+'"> Khối '+thm[i]+'</option>');
        }
 		$('#querry').val('insert');
 		$('#modalNopHS').modal('show');
 	}

    suaNganh = function (button) {
        $('#khoi').empty();

        var thm = $('#'+button.id).data('tohopmon').split(':');
        $('#ma-nganh').val($('#'+button.id).data('idnganh'));
        $('#nguyen-vong').val($('#'+button.id).data('nv'));
        $('#h4-nophs').text("Bạn Chọn Ngành: "+$('#'+button.id).data('tennganh'));
        for (var i = 0; i < thm.length-1; i++) {
            if($('#'+button.id).data('khoi') == thm[i])
                $('#khoi').append('<option value="'+thm[i]+'" selected> Khối '+thm[i]+'</option>');
            else
                $('#khoi').append('<option value="'+thm[i]+' "> Khối '+thm[i]+'</option>');
        }


        $('#query').val('update');
        $('#modalNopHS').modal('show');
    }

 	rutNganh = function (button) {
        ok = confirm("Bạn muốn rút hồ sơ ngành: "+$('#'+button.id).data('tennganh')+"?");
        if(ok){
            $('#ma-nganh').val($('#'+button.id).data('idnganh'));
            $('#query').val('delete');
            submitNopHS();
        }      
   }

 });