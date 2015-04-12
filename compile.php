<?php
set_time_limit(0);

$uId = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,10);;
mkdir($uId,0777);

$mac = substr($_POST['mac_address'],0,17);
$file = $_POST['filename'];

$mac=str_replace(":", "-",$mac);
/*$macRev = strrev($mac);

$confFile = $uId."/config.properties";

$configFile = fopen($confFile,"w");
$txt = "dbm=".$macRev."\n";
$txt .= "dbf=".$file;
fwrite($configFile, $txt);
fclose($configFile);
*/

copy('StartVideo.java',$uId.'/StartVideo.java');

$str=file_get_contents($uId.'/StartVideo.java');

$str=str_replace("{{MAC_ADDRESS_HERE}}", $mac,$str);
$str=str_replace("{{VIDEO_NAME_HERE}}", $file,$str);

file_put_contents($uId.'/StartVideo.java', $str);



shell_exec('javac "'.$uId.'/StartVideo.java"');

$downLoadFile = $uId.'/player.jar';
shell_exec('jar -cvfm '.$downLoadFile.' MANIFEST.MF StartVideo$1.class '.$file.' -C  '.$uId.'/ StartVideo.class');
?>

<?php
$file = $downLoadFile;

$f = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_link = strrpos($f,'/',-1);
$actual_link = substr($f,0,$actual_link);
$actual_link = $actual_link.'/'.$downLoadFile;
echo '<a href="'.$actual_link.'" class="btn btn-success">Your Download is Ready! Click here to Download</a>';
?>
