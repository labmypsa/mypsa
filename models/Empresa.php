<?php

class Empresa extends Model {

    function __construct() {
        $this->table = 'empresas';
        $this->primary_key = 'id';
    }

}