<?php

class EquipoMarca extends Model {

    function __construct() {
        $this->table = 'equipos_marcas';
        $this->primary_key = 'id';
    }

}