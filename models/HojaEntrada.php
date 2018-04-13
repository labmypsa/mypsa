<?php

class HojaEntrada extends Model {

    function __construct() {
        $this->primary_key  = 'id';
        $this->model=[           
        'sucursal' => new Sucursal(),
        ];      
        $this->table = 'hojas_entrada'.$this->model['sucursal']->extension();     
    }

}