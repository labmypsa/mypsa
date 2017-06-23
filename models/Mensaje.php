<?php

class Mensaje extends Model {

    function __construct() {
        $this->table       = 'mensajes';
        $this->primary_key = 'id';
    }

    public function get_inbox(){
    	$this->query = "SELECT * FROM view_mensajes WHERE usuarios_id_destino = ".Session::get('id')." AND eliminado=0 LIMIT 10";
    	$this->get_results_from_query();       
        return $this->rows;
    }
    public function toogle_fav($id){
    	$this->query = "SELECT favorito FROM mensajes WHERE id = ".$id."";
    	$this->get_results_from_query();
    	if($this->rows[0]['favorito'] == 0){
    		$value = 1;
    	} else{
    		$value = 0;
    	}
		$this->query = "UPDATE mensajes SET favorito=".$value." WHERE id=".$id.";";
		$this->execute_single_query();
		return $value;
    }
    public function delete($id){
        $this->query = "UPDATE mensajes SET eliminado=1 WHERE id=".$id.";";
        return $this->execute_single_query();
    }
    public function getPage($page){
        $cantidad = 10;
        if ($page>1) {
            $inicial = (($page-1)*$cantidad)+1;
        } else{
            $inicial = (($page-1)*$cantidad);
        }
        $final =$inicial+$cantidad;
        $this->query = "SELECT * FROM view_mensajes WHERE usuarios_id_destino = ".Session::get('id')." AND eliminado=0 LIMIT ".$inicial.", ".$final."";
        $this->get_results_from_query();
        return $this->rows;
    }

}