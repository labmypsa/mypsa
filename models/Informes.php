<?php

class Informes extends Model { 

    function __construct() {                	    		    	    
        $this->primary_key  = 'id';
        $this->model=[           
        'sucursal' => new Sucursal(),
        'planta' => new Planta(),
        ];      
        $this->table = 'informes'.$this->model['sucursal']->extension();       
    }

    public function equipos_calibrar_notification(){
        $this->query= "SELECT id, CONCAT(descripcion, ' - ', marca) descripcion, prioridad FROM view_".$this->table." WHERE usuarios_calibracion_id = '".Session::get('id')."' AND proceso = 1;";        
        $this->get_results_from_query();
        return $this->rows;
    }

    public function equipos_po_notification(){
        $this->query= "SELECT id, CONCAT(descripcion, ' - ', marca) descripcion, prioridad FROM view_".$this->table." WHERE usuarios_calibracion_id = '".Session::get('id')."' AND proceso = 1;";        
        $this->get_results_from_query();
        return $this->rows;
    }
    

    public function datos_equipo($id){
        $this->query= "SELECT alias, marca, modelo, descripcion FROM view_".$this->table." where id=".$id."";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function datos_cliente($id){
        $this->query= "SELECT concat(nombre,' ',apellido) as contacto, IF(((planta = 'Planta1') OR (planta = 'Planta 1')), empresa, concat(empresa,' ',planta)) AS cliente, direccion, telefono, email FROM view_usuarios where plantas_id=(SELECT plantas_id FROM view_".$this->table." where id=".$id.") and roles_id=10005 limit 1;";       
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
        $this->query= "SELECT id as id,numero_hoja_salida,usuario_id_hoja_salida as usuario_hoja_salida,fecha_hoja_salida as fecha,entrega_hoja_salida as fecha_entrega,comentarios,proceso,po_id,cantidad  FROM ".$view." WHERE id = ". $id.";";
        $this->get_results_from_query();       
        return $this->rows;
    }

    public function get_countfactura($id,$view){
        $this->query= "SELECT Count(factura) as total FROM ".$view." where po_id='". $id ."';";
        $this->get_results_from_query();       
        return $this->rows;
    }

    public function get_factura($id,$view){ // Consulta informacion de factura, cuando entra como opción para actualizar
        $this->query= "SELECT id as id,precio,precio_extra,factura,monedas_id,po_id,comentarios,proceso,descripcion FROM ".$view." WHERE id = ". $id.";";
        $this->get_results_from_query();       
        return $this->rows;
    }

    public function get_prefactura($_query){ // Consulta factura con relación al po, para llenar de manera previa esa información pero puede ser editable.
        $this->query= $_query;
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
        //var_dump($this->query);            
        $this->get_results_from_query();           
        return $this->rows;
    }

    public function get_comparar_cliente($id){
        $this->query= "SELECT plantas_id FROM ".$this->table." WHERE id = ".$id.";";
        $this->get_results_from_query();       
        return $this->rows;
    }
    //Esta función sirve para denegar el seguimiento a las personas no autorizadas (Técnicos)
    public function _redirec($rol,$proceso,$id){
        $array_pages= array('?c=recepcion','?c=calibracion&a=index&p=','?c=salida&a=index&p=','?c=factura&a=index&p=','?c=recepcion');
        // 1 condición de recepción si el técnico esta en proceso de entrada, lo  va a pasar a calibración
        if($rol==3 and ($proceso==0 || $proceso==1) ){ redirect($array_pages[1].$id);} 
        else if($rol != 3 and ($proceso==0 || $proceso==1)){redirect($array_pages[$proceso]);}
        // 2 condición de recepción si el técnico esta en proceso calibracion, lo regresa a su lista de equipos a calibrar
        if($rol==3 and $proceso > 1) {redirect('?c=informes&a=calibrar');} // Regreso al técnico a su historial de equipos.
        else if($proceso > 1){ // proceso [2,3,4]
            if($proceso < 4){redirect($array_pages[$proceso].$id); }
            else{redirect($array_pages[$proceso]);}
        }   
    }

    public function get_reporte_clientes($data){
        $cliente_temp="";             
        $condicion= "WHERE estado_calibracion=1 and activo=1 ";
        $this->query= "SELECT id,l.alias as equipo_id,descripcion,marca,modelo,serie,cliente,fecha_calibracion,fecha_vencimiento,periodo_calibracion,precio,precio_extra,moneda,proceso FROM view_clienteinformes".$data['ext'] ." l ";

        if($data['cliente_id'] != 0){
             $cliente_temp ="and plantas_id=". $data['cliente_id']." ";
             $condicion .= $cliente_temp;
        }
        if($data['tipo_busqueda'] == 0){ //equipos calibrados
             $condicion .="and fecha_calibracion between '". $data['fecha_home']."' and '". $data['fecha_end']."' ";
        }
        if($data['tipo_busqueda'] == 1){ //equipos a vencer
            $this->query .="LEFT Outer JOIN (select temp2.alias from (SELECT * FROM view_informes". $data['ext'] ." where fecha_calibracion >= '". $data['fecha_home']."' ". $cliente_temp .") as temp2) r1 ON l.alias=r1.alias LEFT JOIN ( select temp3.alias from (SELECT * FROM view_informes". $data['ext'] ." where alias is not null and proceso < 4 ". $cliente_temp .") as temp3) r2 ON l.alias=r2.alias";

             $condicion .="and r1.alias is null and r1.alias is null and fecha_vencimiento between '". $data['fecha_home']."' and '". $data['fecha_end']."' ". $cliente_temp ."";
        }
        if($data['tipo_busqueda'] == 2){ //equipos vencidos
            $this->query .= " LEFT Outer JOIN (select temp2.alias from (SELECT * FROM view_informes". $data['ext'] ." where fecha_calibracion >= '". $data['fecha_home']."' ". $cliente_temp .") as temp2) r1 ON l.alias=r1.alias LEFT Outer JOIN (select temp3.alias from (SELECT * FROM view_informes". $data['ext'] ." where alias is not null and proceso < 4 ". $cliente_temp .") as temp3) r2 ON l.alias=r2.alias";

            $condicion .="and r1.alias is null and r2.alias is null and fecha_vencimiento between '". $data['fecha_home']."' and '". $data['fecha_end']."' ". $cliente_temp .""; 
        }        
        $this->query .= $condicion." ;";                          
        $this->get_results_from_query();       
        return $this->rows;
    }

    public function get_productividad($data){
        $sucursal= array('nogales'=>'_n','hermosillo'=>'_h','guaymas'=>'_g');                
        $table="";
        $select="SELECT id,fecha_calibracion FROM view_informes";
        $condicion=" where fecha_calibracion between '". $data['fecha_home'] ."' and '". $data['fecha_end'] ."'";
        $order= " order by fecha_calibracion asc";
        $_totalsc= array();
        
        //Tipo de busqueda 0: 'comparacion del cliente',1:'comparacion de sucursales'      
        if ($data['tipo_busqueda']== 0) {// Cliente
            # code...
            $condicion .=" and plantas_id=". $data['cliente_id'] ." and estado_calibracion=1 ";
                $suctemp= strtolower($data['nombre_suc'][0]);
                $table=$sucursal[$suctemp];

                $this->query =$select .$table .$condicion.$order;                
                $this->get_results_from_query(); 
                $result=$this->rows;             
                $reporte= $this->_productividad($result);
                        
                array_push($_totalsc[$data['cliente_id']]=$reporte); 
        }
        else{//Sucursales
            if (count($data['nombre_suc'])>0) {
                # code...  
                $condicion .=" and estado_calibracion=1 ";                           
                for ($i=0; $i < count($data['nombre_suc']); $i++) { 
                    # code...
                    $this->query =$select;
                    $suctemp= strtolower($data['nombre_suc'][$i]);
                    $table=$sucursal[$suctemp];                     
                    $this->query .=$table .$condicion.$order;
                    //var_dump($this->query);                               
                    $this->get_results_from_query();
                    $result=$this->rows;                  
                    $reporte= $this->_productividad($result);
                    array_push($_totalsc[$suctemp]=$reporte);                    
                }           
            }
        }       
        return $_totalsc;
    }

    public function _productividad($data){
        $meses=array('enero' => 0,'febrero' =>0,'marzo'=>0,'abril'=>0,'mayo'=>0,'junio'=>0,'julio'=>0,'agosto'=>0,'septiembre'=>0,'octubre'=>0,'noviembre'=>0,'diciembre'=>0);
        $list_meses= array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $aniotemp="";
        $arraytotales= array();
        for ($i=0; $i < count($data); $i++) { 
            # code...
            $fecha=strtotime($data[$i]['fecha_calibracion']);           
            $m = date("m", $fecha); 
            $anio=  date("Y", $fecha);           
            if ($i==0) {
                # code...
                $aniotemp=$anio;
            }
            if ($anio==$aniotemp){
                # code...
                $mtemp= $m-1; 
                $nommes= $list_meses[$mtemp];               
                $meses[$nommes]=$meses[$nommes]+1;                
            }
            else{               
                array_push($arraytotales[$aniotemp]=$meses);
                $aniotemp=$anio;                
                $meses=array('enero' => 0,'febrero' =>0,'marzo'=>0,'abril'=>0,'mayo'=>0,'junio'=>0,'julio'=>0,'agosto'=>0,'septiembre'=>0,'octubre'=>0,'noviembre'=>0,'diciembre'=>0);                
                $mtemp= $m-1; 
                $nommes= $list_meses[$mtemp];               
                $meses[$nommes]=$meses[$nommes]+1;
            }                                 
        }
        array_push($arraytotales[$aniotemp]=$meses);
        return $arraytotales;        
    }

    public function get_totalprocesos($data){      
        $_data= array();
        if ($data['tipo_busqueda']== 0) {// Cliente                
            $reporte= $this->_totalprocesos($data,strtolower($data['nombre_suc'][0]));                    
            array_push($_data[$data['cliente_id']]=$reporte);
        }
        else{
             if (count($data['nombre_suc'])>0) {
                for ($i=0; $i < count($data['nombre_suc']); $i++) { 
                    $reporte= $this->_totalprocesos($data,strtolower($data['nombre_suc'][$i]));
                    array_push($_data[$data['nombre_suc'][$i]]=$reporte);   
                }
             }

        }
        return $_data;
    }

    public function _totalprocesos($data,$nom_suc){
 
        $sucursal= array('nogales'=>'_n','hermosillo'=>'_h','guaymas'=>'_g');    
        $procesos= array('Alta','Calibración','Entregados','Facturados','Pagados','Solo_clientes');
        //$fechas= array('fecha_inicio','fecha_calibracion','fecha_hoja_salida','fecha_final','fecha_final');
        //$fechas= array('fecha_inicio','fecha_inicio','fecha_inicio','fecha_inicio','fecha_inicio');
        $select="SELECT count(*) as total FROM view_informes";      
        $and= array(
            "",
            " and estado_calibracion=1",
            " and hojas_salida_id is not null",
            " and proceso > 3 and (calibraciones_id = 1  or calibraciones_id= 2 or  calibraciones_id= 6)",
            " and estado_calibracion=1 and proceso > 3 and precio !=0 and (calibraciones_id = 1  or calibraciones_id= 2 or  calibraciones_id= 6)",
            " and (calibraciones_id = 1  or calibraciones_id= 2 or  calibraciones_id= 6)"
        );       
        $between=" between '".$data['fecha_home']."' and '".$data['fecha_end']."'";            

        $_data = array();

        $cliente = ($data['tipo_busqueda'] == 0) ? " and plantas_id=".$data['cliente_id']."" : "";
        
        for ($i=0; $i < count($procesos) ; $i++) {            
            $table= $sucursal[$nom_suc];
            $condicion=" where fecha_inicio".$between .$and[$i].$cliente;
            $order=" order by fecha_inicio asc;";
            $this->query =$select.$table.$condicion.$order;
            //var_dump($this->query);
            $this->get_results_from_query();            
            $result=$this->rows;           
            array_push($_data[$procesos[$i]]=$result[0]['total']);
        }
        return $_data;
    }

    public function get_query_informe($query){
        $this->query= $query;
        $this->get_results_from_query();       
        return $this->rows;
    }

    


}