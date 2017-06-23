<?php

class Estado extends Model {

    function __construct() {
        $this->table = 'estados';
        $this->primary_key = 'id';
    }

}