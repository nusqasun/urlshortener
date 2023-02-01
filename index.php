<?

$DATA="";
$CONF["file_dst"]="./urlshort.lst";
$CONF["cur_dom"]="https://some.com/";

$URL=addslashes(trim($_SERVER["REQUEST_URI"],"/"));
$return=$VIEW=[];
//$URL=trim(str_replace("path/to/folder","",$URL),"/"); // если не в корне домена

$list=getFromDatabase();
foreach ($list as $k=>$v) {
  $VIEW[]="<div class='urlListElem'>
      <div class='col copyfield longdot'><span class='copybtn'>📋copy</span> <span class='link'>{$v["url"]}</span></div>
      <div class='col copyfield shortlink'><span class='copybtn'>📋copy</span> <span class='link'>{$CONF["cur_dom"]}{$k}</span> [<span class='count'>{$v["cnt"]} просм.</span>]</div>
    </div>";
}
if($URL){
  if(isset($list[$URL])){
    $list[$URL]["cnt"]++;
    saveToDatabase($list);
    header("location:".$list[$URL]["url"]);exit;
  }
  else{
    $return["error"]="Ссылка не корректна";
  }
}
else{
  if(isset($_POST["url"])){
    $url=addslashes(trim($_POST["url"]));
    if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
      $return["error"]="Ссылка не корректна";
    }
    else{
      if($code=newLink($url)){
        $return["url"]=$CONF["cur_dom"].$code;
      }
      else{$return["error"]="Ошибка записи";}
    }
    print json_encode($return);exit;
  }
}

function newLink($url){
  global $list;
  while(isset($list[$code=generateUniqueCode()])){}
  $list[$code]=["url"=>$url,"cnt"=>0];
  if(saveToDatabase($list)){return $code;}
  else return false;
}
function generateUniqueCode() {
  $chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  $code = "";
  for ($i = 0; $i < 7; $i++) {
      $code .= $chars[rand(0, strlen($chars) - 1)];
  }
  return $code;
}
function getFromDatabase() {
  global $CONF;
  $temp=file_get_contents($CONF["file_dst"]);
  return ($temp?unserialize($temp):[]);
}
function saveToDatabase($list) {
  global $CONF;
  if(file_put_contents($CONF["file_dst"], serialize($list)))return true;
  else return false;
}
require_once "tpl.php";