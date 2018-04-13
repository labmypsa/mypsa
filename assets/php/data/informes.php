<?php

$primary_key = 'id';

$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'alias', 'dt' => 1),
    array('db' => 'descripcion', 'dt' => 2),
    array('db' => 'marca', 'dt' => 3),
    array('db' => 'modelo', 'dt' => 4),
    array('db' => 'serie', 'dt' => 5),
    array('db' => 'empresa', 'dt' => 6),
    array('db' => 'planta', 'dt' => 7),
    array('db' => 'direccion', 'dt' => 8),
    array('db' => 'calibracion', 'dt' => 9),    
    array('db' => 'numero_hoja_entrada', 'dt' => 10),
    array('db' => 'usuarios_hoja_entrada', 'dt' => 11),
    array('db' => 'fecha_hoja_entrada', 'dt' => 12),
    array('db' => 'fecha_calibracion', 'dt' => 13),
    array('db' => 'periodo_calibracion', 'dt' => 14),
    array('db' => 'fecha_vencimiento', 'dt' => 15),
    array('db' => 'calibrado_por', 'dt' => 16),
    array('db' => 'informe_hecho_por', 'dt' => 17),
    array('db' => 'acreditacion', 'dt' => 18),
    array('db' => 'numero_hoja_salida', 'dt' => 19),
    array('db' => 'usuario_hoja_salida', 'dt' => 20),
    array('db' => 'fecha_hoja_salida', 'dt' => 21),
    array('db' => 'po_id', 'dt' => 22),
    array('db' => 'cantidad', 'dt' => 23),
    array('db' => 'factura', 'dt' => 24),
    array(
        'db' => 'precio',
        'dt' => 25,
        'formatter' => function($d, $row){
            return '$'.number_format($d,2,'.','');
            }
        ),
    array(
        'db' => 'precio_extra',
        'dt' => 26,
        'formatter' => function($d,$row) {       
            return '$'.number_format($d,2,'.','');
        }
        ),
    array('db' => 'moneda', 'dt' => 27),
    array('db' => 'comentarios', 'dt' => 28),
    array('db' => 'estado_calibracion', 'dt' => 29),
    array('db' => 'nombre_proceso', 'dt' => 30),
    array('db' => 'proceso', 'dt' => 31),
    array('db' => 'prioridad', 'dt' => 32),
    array('db' => 'entrega_hoja_salida', 'dt' => 33)

);