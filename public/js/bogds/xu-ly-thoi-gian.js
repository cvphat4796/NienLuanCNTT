$(function () {
	$('#table-thoigian').DataTable({
 		"dom": 'rt',
 	 	"language": {
            "search": "Tìm kiếm:",
            "processing":     "Đang xử lý...",
            "lengthMenu": "Hiện _MENU_ dòng",
            "zeroRecords": "Không tìm thấy!",
            "info": "Hiện _PAGE_ của _PAGES_",
            "infoEmpty": "Không có dữ liệu",
            "infoFiltered": "(Lọc từ _MAX_ total dòng)"
        },
        ajax:'/bo-giao-duc/get-list-thoi-gian',
        columns:[
        	{data: 4},
        	{data: 2},
        	{data: 3},
        ],
         
        columnDefs: [ 
        			{'targets':[1,2], render: $.fn.dataTable.render.moment(  'DD/MM/YYYY' )},
        			{"targets": [3],
        				"data": null,
        				"render":  function ( data, type, row, meta ) {
        					return '<button class="btn btn-xs btn-primary" id="editTG'+row[0]+'" '
        					+ 'onclick="editTG(this)" '
        					+ 'data-lgtmaso="'+row[0]+'" '
        					+ 'data-tgbd="'+row[2]+'" '
        					+ 'data-tgkt="'+row[3]+'"> '
        					+'<i class="glyphicon glyphicon-edit"></i> Sửa </button>'
        					+ '<button class="btn btn-xs btn-danger" id="deleteTG'+row[0]+'" '
        					+ 'onclick="deleteTG(this)" '
        					+ 'data-lgtmaso="'+row[0]+'" '
        					+ 'data-tenltg="'+row[4]+'" '
        					+'<i class="glyphicon glyphicon-edit"></i> Xóa </button>'
        				}
        			}
                    ],
        
    });


 	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});


    showThemTG = function () {
    	$('#query').val('insert');
    	var ngaybd = $('#datebegin').val('');
    	var ngaykt = $('#dateend').val('');
    	$('#modalThemTG').modal('show');

    }

    themTG = function () {
    	var ltg = $('#ltg').val();
    	var ngaybd = $('#datebegin').val();
    	var ngaykt = $('#dateend').val();
    	var query = $('#query').val();
    	if(query != 'delete'){
    		if(ngaybd=="" || ngaykt == ""){
	    		alert('Bạn Chưa Chọn Ngày!!!!');
	 			return false;
	    	}
	    	var currentDay = new Date().toLocaleDateString().split("/").reverse().join("-");
	    	if(new Date(ngaybd.split("/").reverse().join("-")).getTime() < new Date(currentDay).getTime()){
	    		alert('Ngày Bắt Đầu Phải Lớn Hơn Ngày Hiện Tại!!!!');
	 			return false;
	    	}
	    	if(new Date(ngaybd.split("/").reverse().join("-")).getTime() > new Date(ngaykt.split("/").reverse().join("-")).getTime())
	 		{
	 			alert('Ngày Bắt Đầu Phải Nhỏ Hơn Ngày Kết Thúc!!!!');
	 			return false;
	 		}
    	}
    	$('#proDialog').modal('show');

    	$.ajax({
            url: '/bo-giao-duc/them-thoi-gian',
            type: 'POST',
            data: {ltg: ltg, 
            		ngaybd: ngaybd, 
            		ngaykt: ngaykt, 
            		querry: query},
            success: function (response) {
                alert(response.message);
                if (response.status) {

                	$('#proDialog').modal('hide');
                	$('#modalThemTG').modal('hide');
                    $('#table-thoigian').DataTable().ajax.reload();
                }
                
            }
        });

    } //het su kien them thoi gian

    editTG = function (button) {
    	$('#modalLabelTG').text("Sửa Thời Gian");
    	$('#ltg').val($('#'+button.id).data('lgtmaso'));
    	var datebegin = $('#'+button.id).data('tgbd').split("-").reverse().join("/");
    	$('#datebegin').datepicker('setDate', datebegin);
    	var dateend = $('#'+button.id).data('tgkt').split("-").reverse().join("/");
    	$('#dateend').val(dateend);
    	$('#query').val('update');
        $('#modalThemTG').modal('show');
    }
    //het su kien sua

    deleteTG = function (button) {
    	ok = confirm("Bạn muốn xóa "+$('#'+button.id).data('tenltg')+"?");
 		if(ok){
 			$('#ltg').val($('#'+button.id).data('lgtmaso'));
 			$('#query').val('delete');
 			themTG();
 		}
    }
    //het su kien xoa


    //====================table loai thoi gian=================//
    $('#table-ltg').DataTable({
 		"dom": 'rt',
 	 	"language": {
            "search": "Tìm kiếm:",
            "processing":     "Đang xử lý...",
            "lengthMenu": "Hiện _MENU_ dòng",
            "zeroRecords": "Không tìm thấy!",
            "info": "Hiện _PAGE_ của _PAGES_",
            "infoEmpty": "Không có dữ liệu",
            "infoFiltered": "(Lọc từ _MAX_ total dòng)"
        },
        ajax:'/bo-giao-duc/get-list-loai-thoi-gian',
        columns:[
        	{data: 0},
        	{data: 1},
        ],
         
        columnDefs: [ 
        			{"targets": [2],
        				"data": null,
        				"render":  function ( data, type, row, meta ) {
        					return '<button class="btn btn-xs btn-primary" id="editLTG'+row[0]+'" '
        					+ 'onclick="editLTG(this)" '
        					+ 'data-ltgmaso="'+row[0]+'" '
        					+ 'data-ltgten="'+row[1]+'" '
        					+'<i class="glyphicon glyphicon-edit"></i> Sửa </button>'
        					+ '<button class="btn btn-xs btn-danger" id="deleteLTG'+row[0]+'" '
        					+ 'onclick="deleteLTG(this)" '
        					+ 'data-ltgmaso="'+row[0]+'" '
        					+ 'data-ltgten="'+row[1]+'" '
        					+'<i class="glyphicon glyphicon-edit"></i> Xóa </button>'
        				}
        			}
                    ],
        
    }); // het load table loai thoi gian


   showThemLTG = function () {
    	$('#query').val('insert');
    	$('#ltg_maso').val('');
    	$('#ltg_ten').val('');
    	$('#modalThemLTG').modal('show');

    }//het su kien show modal loai thoi gian

    themLTG = function () {
    	var ltg = $('#ltg_maso').val('');
    	var ltg_ten = $('#ltg_ten').val('');
    	var query = $('#query').val();
    		if(ltg=="" || ltg == ""){
	    		alert('Bạn Chưa Nhập Hết Dữ Liệu!!!!');
	 			return false;
	    	}
    	$('#proDialog').modal('show');

    	$.ajax({
            url: '/bo-giao-duc/them-loai-thoi-gian',
            type: 'POST',
            data: {ltg: ltg, 
            		ltg_ten: ltg_ten, 
            		querry: query},
            success: function (response) {
                alert(response.message);
                if (response.status) {

                	$('#proDialog').modal('hide');
                	$('#modalThemLTG').modal('hide');
                    $('#table-ltg').DataTable().ajax.reload();
                }
                
            }
        });

    } //het su kien them thoi gian

    editLTG = function (button) {
    	$('#modalLabelLTG').text("Sửa Loại Thời Gian");
    	$('#ltg_maso').val($('#'+button.id).data('ltgmaso'));
    	$('#ltg_maso').prop('readonly', true);
    	$('#ltg_ten').val($('#'+button.id).data('ltgten'));
    	$('#query').val('update');
        $('#modalThemLTG').modal('show');
    }
    //het su kien sua

    deleteLTG = function (button) {
    	ok = confirm("Bạn muốn xóa "+$('#'+button.id).data('ltgten')+"?");
 		if(ok){
 			$('#ltg_maso').val($('#'+button.id).data('ltgmaso'));
 			$('#query').val('delete');
 			themLTG();
 		}
    }
});