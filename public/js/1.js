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

//resize
$(document).ready(function() {
	if ($(window).width() < 768 ) {
		$('#xinchao1').removeClass('hidden');
		$('#xinchao2').addClass('hidden');
	}else{
		$('#xinchao2').removeClass('hidden');
		$('#xinchao1').addClass('hidden');
	}
});
$(window).resize(function(event) {
	if ($(window).width() < 768 ) {
		$('#xinchao1').removeClass('hidden');
		$('#xinchao2').addClass('hidden');
	}else{
		$('#xinchao2').removeClass('hidden');
		$('#xinchao1').addClass('hidden');
	}
});
//resize

   
    $("#showDialogMH").click(function(){

         $('#querry').val('insert');
         $('#mh_maso').val("");
 			$('#mh_ten').val("");

    });
});
