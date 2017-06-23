<?php
function redirect($url){
	header('Location: ' . $url);
}
function exists($object){
    if($object != null){
        return true;
    } else{
        include view('error.404');
        exit;
    }
}