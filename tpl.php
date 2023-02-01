<html>
  <head>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="./plugin/js.js"></script>
    <link type="text/css" rel="stylesheet" href="./plugin/style.css">
  </head>
  <body>
    <div class='main'>
      <div class='logo'>Сократ</div>
      <div class='createnewurl'>
        <input id='url_field' type='text' name='url' placeholder='Вставьте ссылку'>
        <input id='url_sendbtn' type='button' value='Сократить'>
      </div>
      <div class='urlGened'></div>
      <section class='urlList'><?=implode("",$VIEW)?></section>
    </div>
  </body>
</html>