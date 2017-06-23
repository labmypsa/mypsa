<?php

class TipoCalibracion extends Model {

    function __construct() {
        $this->table = 'calibraciones';
        $this->primary_key = 'id';
    }

}