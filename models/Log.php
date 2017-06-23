<?php

class Log extends Model {

    function __construct() {
        $this->table        = 'log';
        $this->primary_key  = 'id';
    }

}