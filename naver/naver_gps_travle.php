<?php
$a = $_GET['gps'];
$a = $a."\n";

$file_name = date("Ymd");
$file_name = '/var/www/html/data/log/streetview_log/'.(string)$file_name."gps.log";

$f = fopen($file_name, "a");
fwrite($f, $a);
fclose($f);
?>