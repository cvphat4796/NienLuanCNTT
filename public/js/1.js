 $(function(){
	
		
// nganh

 $("#daihoc").val("#").change(function(){
 	var val = $(this).val();
 	if(val != "#"){
 		$("#nganh").prop('disabled', false);
 	}else{
 		$("#nganh").prop('disabled', true);
 	}
 });


 $("#daihoc").val("#").change(function(){
 	var val = $(this).val();
 	if(val != "#"){
 		$("#btn-timnganh").prop('disabled', false);
 	}else{
 		$("#btn-timnganh").prop('disabled', true);
 	}
 });


//nganh


$('.ngay').datepicker({
    dateFormat: 'dd/mm/yy'
});

//tao tai khoan
$('#quyen').val("sgd").change(function(event) {
	var val = $(this).val();
	if(val == "hs"){
		$('#hocsinh').removeClass('hide');
		$('#thpt').addClass('hide');
	}
	else if(val == "thpt"){
		$('#thpt').removeClass('hide');
		$('#hocsinh').addClass('hide');
	}
	else{
		$('#hocsinh').addClass('hide');
		$('#thpt').addClass('hide');
	}
});

$('#form-taikhoan').submit(function(event) {
	var pass1 = $('#pass1').val();
	var pass2 = $('#pass2').val();
	if (pass1 != pass2) {
		alert("Mật khẩu nhập không khớp");
		event.preventDefault();
	}
});
//tao tai khoan

//login
$('#login').submit(function(event) {
	var user = $('#user').val();
	var pass = $('#pass').val();
	if (user == null || user == "" || pass == null || pass == "") {
		alert("Bạn chưa nhập id, password");
		event.preventDefault();
	}
});
//login

dmk = function (argument) {
	 $('#proDialog').modal('show');
	 return false;
}
//resize
$(document).ready(function() {
	if ($(window).width() < 768 ) {
		$('#xinchao1').removeClass('hidden');
		$('#xinchao2').addClass('hidden');
	}else{
		$('#xinchao2').removeClass('hidden');
		$('#xinchao1').addClass('hidden');
	}

	tableNganhs();
	 $('#tableNganhs_paginate').addClass('dbtb_paginate');
     $('#tableNganhs_length').addClass('dbtb_length');

});

tableNganhs = function () {
 		table = $('#tableNganhs').DataTable({
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
 	 	aLengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tất cả"]],
 	 	iDisplayLength: 10, 
        processing: true,
        ajax:{
        url: '/api-dc/get-nganh',
        dataSrc: 'data'
        },
         columns: [
           {data: 'ngh_maso'},
            {data: 'ngh_ten'},
            {data: 'tohopmon'},
            {data: 'ngh_chitieu'},
            {data: 'ngh_diemchuan'},
            {data: 'ngh_bachoc'},
            {data: 'dh_ten'},
        ],
        initComplete: function () {
            this.api().columns([6]).every( function () {
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

$(window).resize(function(event) {
	if ($(window).width() < 768 ) {
		$('#xinchao1').removeClass('hidden');
		$('#xinchao2').addClass('hidden');
		$('.dataTables_paginate').css({
			float: 'right'
		});
	}else{
		$('#xinchao2').removeClass('hidden');
		$('#xinchao1').addClass('hidden');
	}
});
//resize
	
	$('#btnTimKiem').click(function(event) {
		/* Act on the event */
	});
   
    $("#showDialogMH").click(function(){

         $('#querry').val('insert');
         $('#mh_maso').val("");
 			$('#mh_ten').val("");

    });
});
