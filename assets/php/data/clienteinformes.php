<?php

$primary_key = 'id';

$array1 = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'alias', 'dt' => 1),
    array('db' => 'descripcion', 'dt' => 2),
    array('db' => 'marca', 'dt' => 3),
    array('db' => 'modelo', 'dt' => 4),
    array('db' => 'serie', 'dt' => 5),
    array('db' => 'activo', 'dt' => 6),    
    array('db' => 'cliente', 'dt' => 7),
    array('db' => 'direccion', 'dt' => 8),
    array('db' => 'acreditacion', 'dt' => 9),        
    array('db' => 'fecha_calibracion', 'dt' => 10),
    array('db' => 'periodo_calibracion', 'dt' => 11),
    array('db' => 'fecha_vencimiento', 'dt' => 12),    
    array('db' => 'comentarios', 'dt' => 13),
    array('db' => 'estado_calibracion', 'dt' => 14),
    array('db' => 'proceso', 'dt' => 15),
);
    if($ext=="_nconti")
    {
        $array2= array(
            array('db'=> 'continental_id','dt'=>16),    
            array('db'=> 'um','dt'=>17),
            array('db'=> 'inv_date','dt'=>18),
            array('db'=> 'actual','dt'=>19),
            array('db'=> 'location','dt'=>20),
            array('db'=> 'cal_cycle','dt'=>21),
            array('db'=> 'frecuency','dt'=>22),
            array('db'=> 'cost_center','dt'=>23),   

            );
    }
    else{$array2= array();}

    $columns = array_merge($array1,$array2);