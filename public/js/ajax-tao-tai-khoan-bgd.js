 $(function(){
    
    $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

    submitExcelTHPT = function () {
        var extension = $('#thptfile').val().split('.').pop().toLowerCase();
        if ($.inArray(extension, ['csv', 'xls', 'xlsx']) == -1) {
            alert('chon file khong dung dinh dang');
            return false;

        }
        $('#proDialog').modal({
                                backdrop: 'static',
                                keyboard: false  // to prevent closing with Esc button (if you want this too)
                            });

        var file_data = $('#thptfile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('thpt', file_data);
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
                    $('#tableTHPT').DataTable().ajax.reload()
                }
                
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                   $('#proDialog').modal({
                                show: false
                            });
                }
        });

       
    }

    

 });