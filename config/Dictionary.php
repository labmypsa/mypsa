<?php

function setError($errorNum) {
    $dictionary = array(
            [
            'id' => '001',
            'title' => 'Alerta!',
            'data' => ['msg' => 'Ha ocurrido un problema con la validación de los datos, favor de verificar nuevamente la información. Los datos no se guardaron']
        ], [
            'id' => '002',
            'title' => 'Alerta!',
            'data' => array(['msg' => 'Ha ocurrido un problema al realizar la petición con la base de datos. Favor de reportar el incidente'])
        ], [
            'id' => '003',
            'title' => 'Inicio de sesion!',
            'data' => array(['msg' => 'Los datos no pasaron el sistema de validacion'])
        ], [
            'id' => '004',
            'title' => 'Usuario no valido!',
            'data' => array(['msg' => 'Parece que el usuario no esta registrado en nuestra base de datos'])
        ], [
            'id' => '005',
            'title' => 'Contraseña incorrecta',
            'data' => array(['msg' => 'Favor de verificar la contraseña ingresada'])
        ], [
            'id' => '006',
            'title' => 'Error al subir imagen',
            'data' => array(['msg' => 'Ocurrio un error al subir la imagen, favor de verificar extension y tamaño'])
        ] , [
            'id' => '007',
            'title' => 'Cuenta desabilitada',
            'data' => array(['msg' => 'Al parecer la cuenta con la que intentas ingresar se encuentra desactivada'])
        ], [
            'id' => '008',
            'title' => 'Accion no permitida',
            'data' => array(['msg' => 'No se otorgaron los privilegios necesarios para la accion'])
        ],[
            'id' => '009',
            'title' => 'Accion no realizada',
            'data' => array(['msg' => 'Ha ocurrido un problema al enviar el correo, intentarlo más tarde o reportarlo al administrador'])
        ]
    );
    foreach ($dictionary as $error) {
        if ($error["id"] == $errorNum) {
            return $error;
        }
    }
}
