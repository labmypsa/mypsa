<?php

class EquipoDescripcion extends Model {

    function __construct() {
        $this->table = 'equipos_descripciones';
        $this->primary_key = 'id';
    }

}