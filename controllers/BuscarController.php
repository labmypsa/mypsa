<?php

Session::logged();

class BuscarController {

    public function __construct() {
        $this->name = "buscar";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->models = [
            'usuario' => new Usuario(),
            'informe' => new Informes(),
        ];
    }
    public function index($str) {
        if(strlen($str)>=0){
            $str = strtolower(trim($str));
            $sucursal= Session::get('plantas_id');            
            if ($sucursal== '757') {
                $vistaInformes = 'view_informes_h';           
            }
            if ($sucursal== '758') {
                $vistaInformes = 'view_informes_n';            
            }
            $data['usuario'] = $this->models['usuario']->search($str,['nombre','apellido','email'],'view_usuarios');
            $data['informe'] = $this->models['informe']->search($str,['id'],$vistaInformes);
            include view($this->name . '.index');
        } else{
            include view($this->name . '.index');
        }
    }
}