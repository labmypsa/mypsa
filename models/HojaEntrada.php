<?php

class HojaEntrada extends Model {

    function __construct() {
    	  $sucursal= session::get('plantas_id');    		
    	if ($sucursal== '757') {
    		$this->table        = 'hojas_entrada_h';           
    	}
    	if ($sucursal== '758') {
    		$this->table        = 'hojas_entrada_n';            
    	}
    	// if (sucursal== '') {
    	// 	$this->table        = 'hojas_entrada_g';     
    	// }        
        $this->primary_key  = 'id';
    }

}