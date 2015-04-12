<?php
$str=file_get_contents('StartVideo.java');

$str=str_replace("{{MAC_ADDRESS_HERE}}", "NEW_MAC",$str);

file_put_contents('StartVideo.java', $str);

shell_exec('javac StartVideo.java');
?>