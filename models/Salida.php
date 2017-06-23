<?php 

class Salida extends Model {

    function __construct() {
        $this->primary_key  = 'id';
        $this->model=[           
        'sucursal' => new Sucursal(),
        ];      
        $this->table = 'hojas_salida'.$this->model['sucursal']->extension();
    }


    public function numero_hojasalida(){
        $this->query="SELECT MAX(numero) as numero FROM ".$this->table." where year(fecha) = year(curdate()) and numero like '%-".date('y')."'";
        $this->get_results_from_query();       
        return $this->rows;
    }
   
}