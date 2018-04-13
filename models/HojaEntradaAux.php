<?php

class HojaEntradaAux extends Model {

    function __construct() {
        $this->primary_key  = 'id';
        $this->model=[           
        'sucursal' => new Sucursal(),
        ];      
        $this->table = 'hojas_entrada_aux'.$this->model['sucursal']->extension();    	   
        
    }

}