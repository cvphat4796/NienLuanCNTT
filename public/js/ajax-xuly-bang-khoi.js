 $(function(){
    
 $("#showDialogKhoi").click(function(){

         $('#querryKhoi').val('insert');
         $('#khoi_maso').val("");
            $('#khoi_ten').val("");

    });

 	var data1 = "";
 	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

 	submitKhoi = function(event) {
 		$.ajax({
 			url: '/bo-giao-duc/them-khoi',
 			type: 'POST',
 			data: {khoi_maso: $('#khoi_maso').val(), khoi_ten: $('#khoi_ten').val(), querry: $('#querryKhoi').val()},
 			success: function (response) {
 				alert(response.message);
 				$('#tableKhoi').DataTable().ajax.reload()
 			}
 		});
 		
 	};

 	$(document).ready(function($) {
 		tableKhoi();
         $('#tableKhoi_paginate').addClass('dbtb_paginate');
        $('#tableKhoi_length').addClass('dbtb_length');
 	});
 	

 	tableKhoi = function () {
 		$('#tableKhoi').DataTable({
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
        ajax:{ 
        	url: '/bo-giao-duc/get-list-khoi',
        	dataSrc: function (data) {
        		data1 = data.data;

        		return data.data;
        	}
        	},
        
    });
 	} 

 	
 	editKhoi = function (button) {
        $('#h4-Khoi').text("Sửa Khối");
 		$('#khoi_maso').val($('#'+button.id).data('makhoi'));
 		$('#khoi_ten').val($('#'+button.id).data('tenkhoi'));
 		$('#querryKhoi').val('update');
 		$('#modalKhoi').modal('show');
 	}

 	deleteKhoi = function (button) {
 		ok = confirm("Bạn muốn xóa khối "+$('#'+button.id).data('tenkhoi'));
 		if(ok){
 			$('#khoi_maso').val($('#'+button.id).data('makhoi'));
 			$('#khoi_ten').val($('#'+button.id).data('tenkhoi'));
 			$('#querryKhoi').val('delete');
 			submitKhoi();
 		}
 		
 	}

 });