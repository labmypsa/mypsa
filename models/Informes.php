<?php

class Informes extends Model {        
    function __construct() {          	    		    	       
        $this->primary_key  = 'id';
        $this->model=[           
        'sucursal' => new Sucursal(),
        ];      
        $this->table = 'informes'.$this->model['sucursal']->extension();
    }

    public function equipos_calibrar_notification(){
        $this->query= "SELECT id, CONCAT(descripcion, ' - ', marca) descripcion, prioridad FROM view_".$this->table." WHERE usuarios_calibracion_id = '".Session::get('id')."' AND proceso = 1;";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function datos_equipo($id){
        $this->query= "SELECT alias, marca, modelo, descripcion FROM view_".$this->table." where id=".$id."";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function numero_informe(){      
        $this->query="SELECT MAX(id) as id FROM ".$this->table."";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function get_recepcion($id,$view){
        $this->query= "SELECT id as id, idequipo, alias as equipos_id,descripcion,marca,modelo,serie,empresas_id,plantas_id,periodo_calibracion,acreditaciones_id,usuarios_calibracion_id,calibraciones_id,prioridad,comentarios,po_id,cantidad,numero_hoja_entrada as hojas_entrada_id,usuarios_id_hoja_entrada as usuarios_id,fecha_hoja_entrada as fecha,proceso  FROM ".$view." WHERE id = ". $id.";";
        $this->get_results_from_query();       
        return $this->rows;
    }    

    public function get_calibracion($id,$view){
        $this->query= "SELECT id as id,usuarios_calibracion_id,usuarios_informe_id,fecha_calibracion,acreditaciones_id,periodo_calibracion,comentarios,proceso,estado_calibracion as calibrado  FROM ".$view." WHERE id = ". $id.";"; 
        $this->get_results_from_query();
        return $this->rows;
    }
    public function get_salida($id,$view){
        $this->query= "SELECT id as id,numero_hoja_salida,usuario_id_hoja_salida as usuario_hoja_salida,fecha_hoja_salida as fecha,entrega_hoja_salida as fecha_entrega,comentarios,proceso,po_id  FROM ".$view." WHERE id = ". $id.";";
        $this->get_results_from_query();       
        return $this->rows;
    }

    public function get_factura($id,$view){ // Consulta informacion de factura, cuando entra como opción para actulizar
        $this->query= "SELECT id as id,precio,precio_extra,factura,monedas_id,po_id,comentarios,proceso FROM ".$view." WHERE id = ". $id.";";
        $this->get_results_from_query();       
        return $this->rows;
    }

    public function get_prefactura($id,$view){ // Consulta factura con relación al po, para llenar de manera previa esa información pero puede ser editable.
        $this->query= "SELECT factura,precio,precio_extra,monedas_id FROM ".$view." WHERE po_id='". $id."' limit 1;";
        $this->get_results_from_query();       
        return $this->rows;
    }

    public function get_reporte_totales($data){        
        $query_condicion="SELECT usuarios_calibracion_id as id_tecnico,calibrado_por as tecnico, Count(idequipo) as total_equipos, if(moneda='PESOS',round(SUM(precio + precio_extra),2),0) as total_pesos,if(moneda='DLLS',round(SUM(precio + precio_extra),2),0) as total_dolares FROM view_informes".$data['ext']." where (fecha_calibracion between '".$data['fecha_home']."' and '".$data['fecha_end']."')";
        if($data['usuarios_calibracion_id'] != 0){
             $query_condicion .= " and (usuarios_calibracion_id=". $data['usuarios_calibracion_id'].")"; 
        }
        if($data['calibraciones_id'] != 0){
            $query_condicion .= " and (calibraciones_id=". $data['calibraciones_id'].")";
        }           
        $query_condicion .="  group by usuarios_calibracion_id,moneda,calibrado_por order by usuarios_calibracion_id asc;";       
        $this->query= $query_condicion;             
        $this->get_results_from_query();           
        return $this->rows;
    }

    public function get_comparar_cliente($id){
        $this->query= "SELECT plantas_id FROM ".$this->table." WHERE id = ".$id.";";
        $this->get_results_from_query();       
        return $this->rows;
    }

}