<?php
$query_string = $_GET['gps'];
$query_string = $query_string."\n";
echo $query_string;

$file_name = date("Ymd");
$file_name = "/var/www/html/data/log/roadview_log/".(string)$file_name."gps.log";

echo $file_name;

$f = fopen($file_name, "a");
fwrite($f, $query_string);
fclose($f);
?>