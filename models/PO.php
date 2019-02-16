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
    //Total de equipos que tienen el mismo PO
    public function get_countPO($id,$view){          
        $this->query="SELECT Count(id) as total FROM ".$view." WHERE po_id='". $id ."';";
        $this->get_results_from_query();       
        return $this->rows;
    }
    //Total de equipos que estan listos para enviar a facturar
    public function get_countPOlisto($id,$view){          
        $this->query="SELECT Count(id) as total FROM ".$view." WHERE po_id='". $id ."' and proceso>1 and proceso<4;";
        $this->get_results_from_query();       
        return $this->rows;
    }    

}
