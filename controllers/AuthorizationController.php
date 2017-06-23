<?php

Session::logged();

class AuthorizationController {

    public function __construct() {
        $this->model = [
            'usuario' => new Usuario(),
        ];
    }

    public function index() {
        if (isset($_SESSION['auth'])) {
            $data = validate($_POST, [
                'password' => 'required',
            ]);
            if ($result =$this->model['usuario']->verify_auth($_SESSION['auth'],$data['password'])) {
                foreach ($result as $usuario) {
                    if(password_verify($data['password'],$usuario['password'])){
                        header('location: '.$_SESSION['auth']['url']);
                        $_SESSION['auth']['error'] = 2;
                        exit;
                    }
                }
                Flash::error(setError('008'));
            } else {
                Flash::error(setError('002'));
            }
            unset($_SESSION['auth']);
        }
    }
}