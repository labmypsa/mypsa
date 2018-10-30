<?php

class Usuario extends Model {

    function __construct() {
        $this->table = 'usuarios';
        $this->primary_key = 'id';
    }

    public function get_password($email) {
        $this->query = "SELECT id, password FROM usuarios WHERE email = '" . $email . "';";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function store_session($id) {
        $this->query = "SELECT * FROM view_usuarios WHERE id = '" . $id . "'";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function verify_auth($data){
        $this->query = "SELECT id, password FROM view_usuarios WHERE ".$data['key']."='".$data['value']."'";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function usuario_alta_notification(){
        $this->query= "SELECT * FROM view_".$this->table."_alta order by id desc;";        
        $this->get_results_from_query();
        return $this->rows;
    }   

}
