<?php

class Pais extends Model {

    function __construct() {
        $this->table = 'paises';
        $this->primary_key  = 'id';
    }

}