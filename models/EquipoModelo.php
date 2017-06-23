<?php

class EquipoModelo extends Model {

    function __construct() {
        $this->table = 'equipos_modelos';
        $this->primary_key = 'id';
    }

}