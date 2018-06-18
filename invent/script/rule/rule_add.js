function addNew(){
  var ruleName = $('#txt-rule-name').val();
  if(ruleName.length < 4){
    swal('Error!', 'ชื่อเงื่อนไขต้องมากกว่า 4 ตัวอักษร', 'error');
    return false;
  }

  $.ajax({
    url:'controller/discountRuleController.php?addNew',
    type:'POST',
    cache:'false',
    data:{
      'name' : ruleName
    },
    success:function(rs){
      var rs = $.trim(rs);
      if(isNaN(parseInt(rs))){
        swal('Error !', rs, 'error');
      }else{
        goAdd(rs);
      }
    }
  });
}



function getEdit(){
  $('#txt-rule-name').removeAttr('disabled');
  $('#btn-active-rule').removeAttr('disabled');
  $('#btn-dis-rule').removeAttr('disabled');
  $('#btn-edit').addClass('hide');
  $('#btn-update').removeClass('hide');

}


function activeRule(){
  $('#isActive').val(1);
  $('#btn-active-rule').addClass('btn-success');
  $('#btn-dis-rule').removeClass('btn-danger');
}


function disActiveRule(){
  $('#isActive').val(0);
  $('#btn-active-rule').removeClass('btn-success');
  $('#btn-dis-rule').addClass('btn-danger');
}

function updateRule(){
  var id = $('#id_rule').val();
  var isActive = $('#isActive').val();
  var name = $('#txt-rule-name').val();
  if(isNaN(parseInt(id))){
    swal('ไม่พบ ID Rule');
    return false;
  }

  if(name.length < 4){
    swal('ข้อผิดพลาด!', 'ชื่อเงื่อนไขต้องมากกว่า 4 ตัวอักษร', 'error');
    return false;
  }

  load_in();

  $.ajax({
    url:'controller/discountRuleController.php?updateRule',
    type:'POST',
    cache:'false',
    data:{
      'id' : id,
      'name' : name,
      'isActive' : isActive
    },
    success:function(rs){
      load_out();
      var rs = $.trim(rs);
      if(rs == 'success'){
        swal({
          title:'Updated',
          type:'success',
          timer:1000
        });

        $('#txt-rule-name').attr('disabled','disabled');
        $('#btn-active-rule').attr('disabled', 'disabled');
        $('#btn-dis-rule').attr('disabled', 'disabled');
        $('#btn-update').addClass('hide');
        $('#btn-edit').removeClass('hide');
      }
    }
  });
}
