<?php

class Planta extends Model {

    function __construct() {
        $this->table  = 'plantas';
        $this->primary_key = 'id';
    }

}