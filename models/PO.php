<?php

class PO extends Model {

    function __construct() {    	   
        $this->primary_key  = 'id';
         $this->model=[           
        'sucursal' => new Sucursal(),
        ];      
        $this->table = 'po'.$this->model['sucursal']->extension();
    }

     public function po_pendiente($id){          
        $this->query="SELECT po_id FROM ".$this->table." where id=".$id;
        $this->get_results_from_query();       
        return $this->rows;
    }

    

}
