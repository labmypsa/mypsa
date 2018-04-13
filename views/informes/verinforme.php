<?php 
header('Content-type: application/pdf; charset=utf-8');
$filename=$numinforme;
header('Content-Disposition: inline; filename="'.$filename.'.pdf"');
header('Content-Transfer-Ecoding: binary');
header('Accept-Ranges: bytes');
@readfile($file);
?>