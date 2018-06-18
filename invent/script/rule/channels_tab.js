function saveChannels(){
  id_rule = $('#id_rule').val();
  all_channels = $('#all_channels').val();
  countChannels = parseInt($('.chk-channels:checked').size());

  if(all_channels == 'N' && countChannels == 0){
    swal('กรุณาระบุช่องทางการขายอย่างน้อย 1 รายการ');
    return false;
  }

  ds = [
    {'name':'id_rule', 'value':id_rule},
    {'name':'all_channels', 'value':all_channels}
  ];

  if(all_channels == 'N'){
    i = 0;
    $('.chk-channels').each(function(index, el) {
      if($(this).is(':checked')){
        name = 'channels['+i+']';
        ds.push({'name':name, 'value':$(this).val()});
        i++;
      }
    });
  }


  load_in();
  $.ajax({
    url:'controller/discountRuleController.php?setChannelsRule',
    type:'POST',
    cache:'false',
    data:ds,
    success:function(rs){
      load_out();
      if(rs == 'success'){
        swal({
          title:'Saved',
          type:'success',
          timer:1000
        });
      }else{
        swal('Error!', rs, 'error');
      }
    }
  });
}


function toggleChannels(option){
  if(option == '' || option == undefined){
    option = $('#all_channels').val();
  }

  $('#all_channels').val(option);

  if(option == 'Y'){
    $('#btn-all-channels').addClass('btn-primary');
    $('#btn-select-channels').removeClass('btn-primary');
    $('#btn-show-channels').attr('disabled', 'disabled');
    return;
  }

  if(option == 'N'){
    $('#btn-all-channels').removeClass('btn-primary');
    $('#btn-select-channels').addClass('btn-primary');
    $('#btn-show-channels').removeAttr('disabled');
  }
}


$('.chk-channels').change(function(event) {
  count = 0;
  $('.chk-channels').each(function(index, el) {
    if($(this).is(':checked')){
      count++;
    }
  });
  $('#badge-channels').text(count);
});




function showSelectChannels(){
  $('#channels-modal').modal('show');
}




$(document).ready(function() {
  toggleChannels();
});
