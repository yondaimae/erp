// JavaScript Document
var calback;
function validate_credentials(){
	var s_key 	= $("#s_key").val() != "" ? MD5($("#s_key").val()) : false;
	var id_tab 	= $("#validateTab").val();
	var field 		= $("#validateField").val();
	if( s_key != false ){
		$.ajax({
			url:"controller/credentialsController.php?validateCredentials",
			type:"POST", cache:"false", data:{ "id_tab" : id_tab, "s_key" : s_key, "field" : field },
			success: function(rs){
				var rs = $.trim(rs);
				if( isJson(rs) ){
					var data = $.parseJSON(rs);
					$("#approverName").val(data.approver);
					$("#approveToken").val(data.token);
					closeValidateBox();
					callback();
					return true;
				}else{
					showValidateError(rs);
					return false;
				}
			}
		});
	}else{
		showValidateError('Please enter your secure code');
	}
}


//---- id tab = tab menu    callback is function to call after valid s_key successfull
//-- { data } is object with key "title" : title for modal, "id_tab" : id tab menu , "field" : field of right , "callback" : callback function
function showValidateBox(data){
	callback = data.callback;
	$("#validateTab").val(data.id_tab);
	$("#validateField").val(data.field);
	if( data.title != "" ){
		$("#validate-modal-title").text(data.title);
	}
	$("#s_key").val('');
	$("#sKey-error").addClass('not-show');
	$("#validate-modal").modal('show');	
}
	
function closeValidateBox(){
	$("#validate-modal").modal('hide');
	$("#s_key").val('');
	//$("#sKey-error").text('');
	$("#sKey-error").addClass('not-show');
}

function showValidateError(rs){
	$("#sKey-error").text(rs);
	$("#sKey-error").removeClass('not-show');
}

$("#s_key").keyup(function(e){
	if( e.keyCode == 13 ){
		validate_credentials();
	}
});

$("#validate-modal").on('shown.bs.modal', function(){ $("#s_key").focus(); });