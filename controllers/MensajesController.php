<?php

Session::logged();

require 'vendor/autoload.php';
use Carbon\Carbon;

class MensajesController {

    public function __construct() {
    	Carbon::setLocale('es');
        $this->name = "mensajes";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model=[
  			'mensaje' => new Mensaje()
  		];
        
    }

    public function index() {
    	$data['mensaje'] = $this->model['mensaje']->get_inbox();
        $count_unread_menssages = 0;
		for ($i=0; $i < count($data['mensaje']); $i++) {
            if($data['mensaje'][0]['leido'] == 0){$count_unread_menssages++;}
			$fechaMensaje = strtotime($data['mensaje'][$i]['fecha']);
			$fechaMensaje = Carbon::create(date('Y', $fechaMensaje), date('m', $fechaMensaje), date('d', $fechaMensaje), date('H', $fechaMensaje), date('i', $fechaMensaje), date('s', $fechaMensaje));
			$diferencia = Carbon::now()->diffInSeconds($fechaMensaje);
			$fecha = Carbon::now()->subSeconds($diferencia)->diffForHumans();
			$data['mensaje'][$i]['fecha'] = $fecha;
		}
    	$count_mensajes = count($data['mensaje']);
        include view($this->name . '.index');
    }
    public function get_inbox(){
    	$data['mensaje'] = $this->model['mensaje']->get_inbox();
		for ($i=0; $i < count($data['mensaje']); $i++) { 
			$fechaMensaje = strtotime($data['mensaje'][$i]['fecha']);
			$fechaMensaje = Carbon::create(date('Y', $fechaMensaje), date('m', $fechaMensaje), date('d', $fechaMensaje), date('H', $fechaMensaje), date('i', $fechaMensaje), date('s', $fechaMensaje));
			$diferencia = Carbon::now()->diffInSeconds($fechaMensaje);
			$fecha = Carbon::now()->subSeconds($diferencia)->diffForHumans();

			$data['mensaje'][$i]['fecha'] = $fecha;
		}
    	echo $data = json_encode($data['mensaje']);
    }
    public function toogle_fav(){
        if($this->model['mensaje']->toogle_fav($_GET['id']) == 1){
            echo 1;
        } else{
            echo 0;
        }
    }
    public function delete(){
        if($this->model['mensaje']->delete($_GET['id'])){
            echo 1;
        } else{
            echo 0;
        }
    }
    public function getPage(){
        echo json_encode($this->model['mensaje']->getPage($_GET['page']));
    }
}
