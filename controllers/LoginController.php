<?php

class LoginController {

    public function __construct() {
        $this->model = new Usuario();
    }

    public function index() {
        include view('login.index');
    }
    public function lock(){
        if(!isset($_SESSION['lock']) && !isset($_COOKIE['lock'])){
            Session::lock();
        }
        include view('login.lockscreen');
    }
    public function unlock(){
        if ($data = validate($_POST, [
            'password' => 'required|min:3',
        ])) {
            $data['email'] = Session::get('email');
            if ($this->data = $this->model->get_password($data['email'])) {
                $user = $this->data[0];
                if ($login = password_verify($data['password'], $user['password'])) {
                    Session::unlock();
                    redirect('index.php');
                } else {
                    Flash::error(setError('005'));
                }
            } else{
                Flash::error(setError('004'));
            }
        } else{
            Flash::error(setError('003'));
        }
    }
    public function login() {
        if ($data = validate($_POST, [
            'email' => 'required',
            'password' => 'required|min:3',
        ])) {
            if ($this->data = $this->model->get_password($data['email'])) {
                $user = $this->data[0];
                if ($login = password_verify($data['password'], $user['password'])) {
                    if (isset($data['remember'])) {
                        Session::store($user['id'], true);
                        if(Session::get('activo') == 'si'){
                            Logs::this('login','cookie');
                            $_SESSION['log'] = true;
                            redirect('index.php');
                        } else{
                            unset($_SESSION['session']);
                            setcookie('session', '', time() - 3600, '/');
                            Flash::error(setError('007'));
                        }
                    } else {
                        Session::store($user['id'], false);
                        if(Session::get('activo') == 'si'){
                            Logs::this('login');
                            $_SESSION['log'] = true;
                            redirect('index.php');
                        } else{
                            unset($_SESSION['session']);
                            setcookie('session', '', time() - 3600, '/');
                            Flash::error(setError('007'));
                        }
                    }
                } else {
                    Flash::error(setError('005'));
                }
            } else {
                Flash::error(setError('004'));
            }
        } else {
            Flash::error(setError('003'));
        }
    }

    public function logout() {        
        Session::destroy();
        Logs::this('logout','Session terminada exitosamente');
    }
}