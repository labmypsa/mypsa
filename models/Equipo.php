<?php

class Equipo extends Model {

    function __construct() {
        $this->table = 'equipos';
        $this->primary_key = 'id';
    }

}
