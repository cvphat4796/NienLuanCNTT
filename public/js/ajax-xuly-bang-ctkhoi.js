 $(function(){
    
 $("#showDialogKhoiNganh").click(function(){

         $('#querryKhoiNganh').val('insert');
         $('#khoi_maso').val("");
            $('#khoi_ten').val("");

    });

 	var data1 = "";
 	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

 	submitKhoiNganh = function(event) {
 		$.ajax({
 			url: '/bo-giao-duc/them-khoi',
 			type: 'POST',
 			data: {khoi_maso: $('#khoi_maso').val(), khoi_ten: $('#khoi_ten').val(), querry: $('#querryKhoiNganh').val()},
 			success: function (response) {
 				alert(response.message);
 				$('#tableKhoiNganh').DataTable().ajax.reload()
 			}
 		});
 		
 	};

 	$(document).ready(function($) {
 		tableKhoiNganh();
 	});
 	

 	tableKhoiNganh = function () {
 		$('#tableKhoiNganh').DataTable({
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
        ajax:'/bo-giao-duc/get-list-khoi-nganh',
        "columns": [
            { "data": 1 },
            { "data": 3 },
            { "data": 5 },
            { "data": 7 }
          ],
        "columnDefs": [ {
            "targets": 4,
            "data": "download_link",
            "render": function ( data, type, row, meta ) {
              return '<button onclick="edit(this)" '
                    +'data-makhoi="'+row[0]+'"'
                    +'data-mon1="'+row[2]+'"'
                    +'data-mon2="'+row[4]+'"'
                    +'data-mon3="'+row[6]+'" id="edit-'+row[1]+'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Sửa</button>'
                    + 
                        '<button onclick="deletes(this)" data-mamon="'+row[1]+'" data-tenmon="'+row[1]+'" id="delete-'+row[1]+'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-trash"></i> Xóa</button> ';
            }
          } ],
        });
 	} 

 	
 	editKhoiNganh = function (button) {
 		$('#khoi_maso').val($('#'+button.id).data('makhoi'));
 		$('#khoi_ten').val($('#'+button.id).data('tenkhoi'));
 		$('#querryKhoi').val('update');
 		$('#modalKhoi').modal('show');
 	}

 	deleteKhoiNganh = function (button) {
 		ok = confirm("Bạn muốn xóa khối "+$('#'+button.id).data('tenkhoi'));
 		if(ok){
 			$('#khoi_maso').val($('#'+button.id).data('makhoi'));
 			$('#khoi_ten').val($('#'+button.id).data('tenkhoi'));
 			$('#queryKhoiNganh').val('delete');
 			submitKhoi();
 		}
 		
 	}

 });