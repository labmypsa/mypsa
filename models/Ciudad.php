<?php

class Ciudad extends Model {

    function __construct() {
        $this->table = 'ciudades';
        $this->primary_key = 'id';
    }

}
