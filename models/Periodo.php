<?php

class Periodo extends Model {

    function __construct() {
        $this->table = 'periodo';
        $this->primary_key = 'id';    
    }

}