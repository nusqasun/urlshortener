<html>
  <head>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <style>
      input[type=button]{cursor:pointer;}
      .logo{font-size:35px;text-align:center;margin-bottom:40px;}
      .createnewurl{width:600px;margin:0 auto;text-align:center;}
      #url_field{padding:5px;font-size:18px;}
      #url_sendbtn{padding:5px 10px;font-size:18px;}
      .urlGened{font-size:30px;color:#0e860a;text-align:center;padding:10px;}
      .urlGened.red{color:red;}
      .urlGened.green{color:#0e860a;}
      .urlList {display: table;width: 100%;}
      .urlList > .urlListElem {display: table-row;}
      .urlList .col {display: table-cell;}
    </style>
    <script>
      $(document).ready(function(){
        $('#url_sendbtn').on('click',function(){sendUrl();});
        $('body').on('keypress', '.search_gallery_input', function(args) {
          if (args.keyCode == 13) {
            $('#url_sendbtn').click();
            return false;
          }
        });
      });
      function sendUrl(){
        var url=$('#url_field').val();
        if(url!=''){
          $('#url_field,#url_sendbtn').prop('disabled',true);
          $.post('', {'url':url})
          .done(function(data) {
            var obj = JSON.parse(data);
            if(obj.error===undefined){
              $('.urlGened').val(obj.url);$('.urlGened').addClass('green');$('.urlGened').removeClass('red');
            }
            else{$('.urlGened').val(obj.error);$('.urlGened').addClass('red');$('.urlGened').removeClass('green');}
          })
          .fail(function() {
            $('.urlGened').val("Ошибка связи, пожалуйста повторите позднее.");
          })
          .always(function() {
            $('#url_field,#url_sendbtn').prop('disabled',false);
          });
        }
      }
    </script>
  </head>
  <body>
    <div class='main'>
      <div class='logo'>Сократ</div>
      <div class='createnewurl'>
        <input id='url_field' type='text' name='url' placeholder='Вставьте ссылку'>
        <input id='url_sendbtn' type='button' value='Сократить'>
      </div>
      <div class='urlGened'></div>
      <div class='urlList'><?=implode("",$VIEW)?></div>
    </div>
  </body>
</html>