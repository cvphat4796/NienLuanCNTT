 $(function(){
    

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
 	 	aLengthMenu: [[3, 5, 10, 25, -1], [3, 5, 10, 25, "Tất cả"]],
 	 	iDisplayLength: 3, 
        processing: true,
        "order": [[ 6, "asc" ]],
        ajax:{
        url: '/hoc-sinh/get-list-nganh',
        dataSrc: 'data'
        },
         columns: [
           {data: 'ngh_maso'},
            {data: 'ngh_ten'},
            {data: 'ngh_khoi'},
            {data: 'ngh_chitieu'},
            {data: 'ngh_diemchuan'},
            {data: 'ngh_bachoc'},
            {data: 'douutien'},
            {data: 'dh_id'},
            {data: 'action'},
        ],
        columnDefs:[
             {"sType": 'formatted-num', target: 6},
        ],
        initComplete: function () {
            this.api().columns([7]).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value=""> Tất Cả</option></select>')
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
 	
 	nopNganh = function (button) {

        $('#khoi').empty();
        var mathm = $('#'+button.id).data('khoi').split(':'); 
        var thm = $('#'+button.id).data('tohopmon').split(';');
        $('#ma-nganh').val($('#'+button.id).data('idnganh'));
        $('#nguyen-vong').val('');
        $('#h4-nophs').text("Bạn Chọn Ngành: "+$('#'+button.id).data('tennganh').split(':')[0]);
        for (var i = 0; i < thm.length-1; i++) {
            $('#khoi').append('<option value="'+mathm[i]+'"> Khối '+thm[i]+'</option>');
        }
 		$('#query').val('insert');
 		$('#modalNopHS').modal('show');
 	}

    suaNganh = function (button) {
        $('#khoi').empty();
        var mathm = $('#'+button.id).data('khoi').split(':'); 
        var thm = $('#'+button.id).data('tohopmon').split(';');
        $('#ma-nganh').val($('#'+button.id).data('idnganh'));
        $('#nguyen-vong').val($('#'+button.id).data('nv'));
        $('#h4-nophs').text("Bạn Chọn Ngành: "+$('#'+button.id).data('tennganh').split(':')[0]);
        for (var i = 0; i < thm.length-1; i++) {
            if($('#'+button.id).data('khoi') == thm[i])
                $('#khoi').append('<option value="'+mathm[i]+'" selected> Khối '+thm[i]+'</option>');
            else
                $('#khoi').append('<option value="'+mathm[i]+' "> Khối '+thm[i]+'</option>');
        }


        $('#query').val('update');
        $('#modalNopHS').modal('show');
    }

 	rutNganh = function (button) {
        ok = confirm("Bạn muốn rút hồ sơ ngành: "+$('#'+button.id).data('tennganh').split(':')[0]+"?");
        if(ok){
            $('#ma-nganh').val($('#'+button.id).data('idnganh'));
            $('#query').val('delete');
            submitNopHS();
        }      
   }

 });