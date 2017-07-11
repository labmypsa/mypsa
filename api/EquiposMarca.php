<?php

require '../config/Api.php';

if (isset($_GET['q']) && strlen($_GET['q']) > 0){
	$string = $_GET['q'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$api = new Api();

	echo json_encode($api->get('view_equipos_marcas', $string, $page));

} else{
	echo '0 found';
}