<?php

class Rol extends Model {

    function __construct() {
        $this->table       = 'roles';
        $this->primary_key = 'id';
    }

}