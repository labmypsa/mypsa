<?php

class HojaEntradaAux extends Model {

    function __construct() {
    	  $sucursal= Session::get('plantas_id');    		
    	if ($sucursal== '757') {
    		$this->table        = 'hojas_entrada_aux_h';           
    	}
    	if ($sucursal== '758') {
    		$this->table        = 'hojas_entrada_aux_n';            
    	}
    	// if (sucursal== '') {
    	// 	$this->table        = 'hojas_entrada_aux_g';     
    	// }        
        $this->primary_key  = 'id';
    }

}