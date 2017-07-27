<?php

class Logs{

    public static function this($action, $details = null) {
		$table = 'logs';
		$user = 'usuarios_id';
        $data = [
            $user => Session::get('id'),
            'accion' => $action
        ];
        $conn = new mysqli(APP_SERVER, APP_USER, APP_PASS, APP_DB);
        $conn->set_charset("utf8");
		if ($details == null) {
            $query = "INSERT INTO ".$table." ($user, accion) VALUES ('" . $data[$user] . "', '" . $data['accion'] . "');";
        } else{
            $data['detalles'] = $details;
            $query = "INSERT INTO ".$table." ($user, accion, detalles) VALUES ('" . $data[$user] . "', '" . $data['accion'] . "', '".$data['detalles']."');";
        }
        $conn->query($query);
        $conn->close();
    }
}