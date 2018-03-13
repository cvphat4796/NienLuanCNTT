 $(function(){
    
 $("#showDialogKhoiNganh").click(function(){

        $('#querryKhoiNganh').val('insert');
        $('#sel-khoi').find('option').remove().end();
        $('#sel-mon1').find('option').remove().end();
        $('#sel-mon2').find('option').remove().end();
        $('#sel-mon3').find('option').remove().end();

            $.ajax({
                url: '/bo-giao-duc/get-them-khoi-nganh',
                type: 'POST',
                data: {querry: $('#querryKhoiNganh').val()},
                success: function (response) {
                    if(!$.isEmptyObject(response.listKhoi))
                        addOptionToSelect('sel-khoi',response.listKhoi,'khoi_maso','khoi_mota');
                    addOptionToSelect('sel-mon1',response.listMon,'mh_maso','mh_ten');
                    addOptionToSelect('sel-mon2',response.listMon,'mh_maso','mh_ten');
                    addOptionToSelect('sel-mon3',response.listMon,'mh_maso','mh_ten');
                   
                }
            });
        
    });

 	var data1 = "";
 	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

 	submitKhoiNganh = function(event) {
        if($('#sel-mon1').val() == $('#sel-mon2').val() || $('#sel-mon1').val() ==$('#sel-mon3').val() || $('#sel-mon2').val() == $('#sel-mon3').val()){
            alert('Chọn trùng môn!');
            return false;
        } 
        else{
            $.ajax({
                url: '/bo-giao-duc/them-khoi-nganh',
                type: 'POST',
                data: {khoi: $('#sel-khoi').val(), mon1: $('#sel-mon1').val(), mon2: $('#sel-mon2').val(), mon3: $('#sel-mon3').val(), querry: $('#querryKhoiNganh').val()},
                success: function (response) {
                    alert(response.message);
                    $('#tableKhoiNganh').DataTable().ajax.reload()
                }
            });
        }
 		
 		
 	};

 	$(document).ready(function($) {
 		tableKhoiNganh();
        
        $('#tableKhoiNganh_paginate').addClass('dbtb_paginate');
        $('#tableKhoiNganh_length').addClass('dbtb_length');
        $.ajax({
                url: '/bo-giao-duc/get-them-khoi-nganh',
                type: 'POST',
                data: {querry: $('#querryKhoiNganh').val()},
                success: function (response) {
                    if(!$.isEmptyObject(response.listKhoi))
                        addOptionToSelect('sel-khoi',response.listKhoi,'khoi_maso','khoi_mota'); 
                    addOptionToSelect('sel-mon1',response.listMon,'mh_maso','mh_ten');
                    addOptionToSelect('sel-mon2',response.listMon,'mh_maso','mh_ten');
                    addOptionToSelect('sel-mon3',response.listMon,'mh_maso','mh_ten');                  
                }
            });
 	});

    addOptionToSelect = function(id,array,para1,para2) {
        temp = array[0];
        $.each(array, function (i, item) {
                $('#'+id).append($('<option>', { 
                    value: item[para1],
                    text : item[para2]
                }));            
        });
        $("#"+id).val(temp[para1]);
    }
 	

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
            { "data": 7 },
            { "data": 5 },
            { "data": 3 },
            { "data": 1 }
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

 	
 	editCTK = function (button) {
 		$('#h4-KN').text("Sửa Tổ Hợp Môn");
        $('#querryKhoiNganh').val('update');
        $('#sel-khoi').find('option').remove().end();
        $.ajax({
                url: '/bo-giao-duc/get-them-khoi-nganh',
                type: 'POST',
                data: {querry: $('#querryKhoiNganh').val()},
                success: function (response) {
                    addOptionToSelect('sel-khoi',response.listKhoi,'khoi_maso','khoi_mota');    
                     $("#sel-khoi").val($('#'+button.id).data('makhoi')).change();    
                }
            });
       
        $("#sel-mon1").val($('#'+button.id).data('mon1')).change();
        $("#sel-mon2").val($('#'+button.id).data('mon2')).change();
        $("#sel-mon3").val($('#'+button.id).data('mon3')).change();
        $('#modalKhoiNganh').modal('show');    
 	}

 	deleteCTK = function (button) {
 		ok = confirm("Bạn muốn xóa khối "+$('#'+button.id).data('tenkhoi'));
 		if(ok){
 			$("#sel-khoi").val($('#'+button.id).data('makhoi'));
            $("#sel-mon1").val($('#'+button.id).data('mon1'));
            $("#sel-mon2").val($('#'+button.id).data('mon2'));
            $("#sel-mon3").val($('#'+button.id).data('mon3'));
 			$('#querryKhoiNganh').val('delete');
 			submitKhoiNganh();
 		}
 		
 	}

 });