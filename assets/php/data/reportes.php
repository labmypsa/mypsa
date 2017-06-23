<?php

$primary_key = 'id';

$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'alias', 'dt' => 1),
    array('db' => 'descripcion', 'dt' => 2),
    array('db' => 'marca', 'dt' => 3),
    array('db' => 'modelo', 'dt' => 4),
    array('db' => 'serie', 'dt' => 5),
    array('db' => 'activo', 'dt' => 6),    
    array('db' => 'cliente', 'dt' => 7),
    array('db' => 'calibracion', 'dt' => 8),
    array('db' => 'precio', 'dt' => 9),        
    array('db' => 'precio_extra', 'dt' => 10),
    array('db' => 'moneda', 'dt' => 11),
    array(
        'db' => 'fecha_calibracion',
        'dt' => 12
         ),    
    array(
            'db' => 'fecha_inicio',
            'dt' => 13,
            'formatter'=> function( $d, $row ) { 
            $start= strtotime($d);              
            $end= strtotime($row[12]);
            $count =0;
            while(date('Y-m-d',$start)< date('Y-m-d',$end))
            {
                $count += date('N',$start) < 6 ? 1:0;
                $start = strtotime("+1 day",$start);
            }
            return $count;                            
            }
        ),        
     array(
            'db' => 'fecha_salida',
            'dt' => 14,
            'formatter'=> function( $d, $row ) {                
                $start= strtotime($row[12]);              
                $end= strtotime($d);
                $count =0;
                while(date('Y-m-d',$start)< date('Y-m-d',$end))
                {
                    $count += date('N',$start) < 6 ? 1:0;
                    $start = strtotime("+1 day",$start);
                }
                return $count;
            }
        ),    
    array('db' => 'proceso', 'dt' => 15),
);

?>