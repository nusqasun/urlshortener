$(document).ready(function(){
  $('#url_sendbtn').on('click',function(){sendUrl();});
  $('.longdot,.shortlink').on('click',function(){
    let text = $(this).children('.link').html();
    copyToClipboard(text);
  });
  $('body').on('keypress', '.search_gallery_input', function(args) {
    if (args.keyCode == 13) {
      $('#url_sendbtn').click();
      return false;
    }
  });
});
function copyToClipboard(text) {
  var textArea = document.createElement("textarea");
  textArea.value = text;
  document.body.appendChild(textArea);
  textArea.select();
  document.execCommand("copy");
  textArea.remove();
}
function sendUrl(){
  var url=$('#url_field').val();
  if(url!=''){
    $('#url_field,#url_sendbtn').prop('disabled',true);
    $('.urlGened').html('');
    $.post('', {'url':url})
    .done(function(data) {
      var obj = JSON.parse(data);
      if(obj.error===undefined){
        $('.urlGened').html(obj.url);$('.urlGened').addClass('green');$('.urlGened').removeClass('red');
      }
      else{$('.urlGened').html(obj.error);$('.urlGened').addClass('red');$('.urlGened').removeClass('green');}
    })
    .fail(function() {
      $('.urlGened').html("Ошибка связи, пожалуйста повторите позднее.");
    })
    .always(function() {
      $('#url_field,#url_sendbtn').prop('disabled',false);
    });
  }
}