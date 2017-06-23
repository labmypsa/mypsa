<?php

class RegistroController {

    public function __construct() {
       $this->model = [
            'usuario' => new Usuario(),
        ];
    }

    public function index() {
        include view('registro.index');
    }
    public function correcto(){
    	include view('registro.success');
    }
    public function store(){
        $data = validate($_POST, [
            'password' => 'required',
            'email' => 'required|trimlower|email|unique:usuarios',
            'nombre' => 'required|trimlower',
            'apellido' => 'required|trimlower',
            'empresa' => 'required|trimlower',
            'sucursal' => 'required|trimlower',
        ]);

        /*|***************************************|*/
        /*|     Enviar correos electronicos       |*/
        /*|      Enviar a cliente y admins        |*/
        /*|***************************************|*/
        
  		unset($data['empresa']);
  		unset($data['sucursal']);

        $data["password"] = Crypt::encrypt($data["password"]);
        $data['roles_id'] = '10005';


        if ($this->model['usuario']->store($data)) {
            redirect('?c=registro&a=correcto');
        } else {
            Flash::error(setError('002'));
        }
    }


}

