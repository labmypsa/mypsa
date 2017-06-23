<?php

class Sucursal extends Model {

    function __construct() {
        $this->table       = 'sucursales';
        $this->primary_key = 'id';       
    }

    function extension(){
    	$sucursal=Session::get('sucursal');
    	$ext="";
    	if ($sucursal== 'Nogales') {$ext="_n"; }
        else if($sucursal== 'Hermosillo') {$ext="_h"; }
        else if($sucursal== 'Guaymas') {$ext="_g"; }
        return $ext;
    }

}