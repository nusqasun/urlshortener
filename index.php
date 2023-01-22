<?

$DATA="";
$CONF["file_dst"]="./urlshort.lst";
$CONF["cur_dom"]="https://some.com/";

$URL=addslashes(trim($_SERVER["REQUEST_URI"],"/"));
$URL="";
$return=[];


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
    }
  }
}

$list=getFromDatabase();
foreach ($list as $k=>$v) {
  $VIEW[]="<div class='urlListElem'><div class='col'>{$k}</div><div class='col'>{$v["url"]}</div><div class='col'>{$v["cnt"]}</div></div>";
}

require_once "tpl.php";

function newLink($url){
  global $list;
  while(isset($list[$code=generateUniqueCode()])){}
  $list[$code]=["url"=>$url,"cnt"=>0];
  if(saveToDatabase($list)){return $code;}
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
  $myfile = fopen($CONF["file_dst"], "r");
  $a=unserialize(fgets($myfile));
  fclose($myfile);
  return $a;
  //return unserialize(file_get_contents($CONF["file_dst"]));
}
function saveToDatabase($list) {
  global $CONF;
  
  $myfile = fopen($CONF["file_dst"], "w");
  fwrite($myfile, serialize($list));
  fclose($myfile);

  //file_put_contents($CONF["file_dst"], serialize($list));
  return true;
}