 $(function(){
 	var data1 = "";
 	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

 	submit = function(event) {
 		$.ajax({
 			url: '/bo-giao-duc/them-mon-hoc',
 			type: 'POST',
 			data: {mh_maso: $('#mh_maso').val(), mh_ten: $('#mh_ten').val(), querry: $('#querry').val()},
 			success: function (response) {
 				alert(response.message);
 				$('#tableMH').DataTable().ajax.reload()
 			}
 		});
 		
 	};

 	$(document).ready(function($) {
 		tableMH();
         $('#tableMH_paginate').addClass('dbtb_paginate');
        $('#tableMH_length').addClass('dbtb_length');
 	});
 	

 	tableMH = function () {
 		$('#tableMH').DataTable({
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
        ajax:'/bo-giao-duc/get-list-mon-hoc',
        
    });
 	} 

 	
 	edit = function (button) {
        $('#h4-MH').text("Sửa Môn Học");
 		$('#mh_maso').val($('#'+button.id).data('mamon'));
 		$('#mh_ten').val($('#'+button.id).data('tenmon'));
 		$('#querry').val('update');
 		$('#myModal').modal('show');
 	}

 	deletes = function (button) {
 		ok = confirm("Bạn muốn xóa môn "+$('#'+button.id).data('tenmon'));
 		if(ok){
 			$('#mh_maso').val($('#'+button.id).data('mamon'));
 			$('#mh_ten').val($('#'+button.id).data('tenmon'));
 			$('#querry').val('delete');
 			submit();
 		}
 		
 	}

 });