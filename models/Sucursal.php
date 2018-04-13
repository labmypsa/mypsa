<?php

class Sucursal extends Model {

    function __construct() {
        $this->table       = 'sucursales';
        $this->primary_key = 'id';       
    }

    function extension($_ext){

    	$sucursal = strtolower(Session::get('sucursal'));       
    	$ext="";
    	if ( $sucursal== 'nogales') {$ext="_n"; }
        else if($sucursal== 'hermosillo') {$ext="_h"; }
        else if($sucursal== 'guaymas') {$ext="_g"; }
        return $ext;
    }

}