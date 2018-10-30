<?php

class LoginController {

    public function __construct() { 

         $this->model = [
            'usuario' => new Usuario(),
            'informe' => new Informes(),
        ];            
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
            if ($this->data = $this->model['usuario']->get_password($data['email'])) {
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
            if ($this->data = $this->model['usuario']->get_password($data['email'])) {
                $user = $this->data[0];
                if ($login = password_verify($data['password'], $user['password'])) {
                    if (isset($data['remember'])) {
                        Session::store($user['id'], true);
                        if(Session::get('activo') == 'si'){
                            Logs::this('Inicio sesión','Se usó opción de “Recordar”');
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
                            Logs::this('Inicio sesión');
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
        Logs::this('Cerro sesión','El usuario cerro sesión');
    }

    public function sucursal() {
        Session::logged(['roles_id'=>'10000']);
        $suc = array("n","h","g");    
        for($i=0; $i<3; $i++)
        {
            $query="SELECT count(id) as count FROM informes_".$suc[$i]." where proceso=1 union all select count(id) FROM informes_".$suc[$i]." where proceso=2 union all select count(id) FROM informes_".$suc[$i]." where proceso=3;";           
            $data['result'][$i] = $this->model['informe']->get_query_informe($query);
        }     
        include view('login.sucursal');        
    }

    public function edit_sucursal() {
        $sucursal= $_POST['var1'];
        $plantas_id="";
        if ( $sucursal== 'nogales') {$plantas_id="758"; }
        else if($sucursal== 'hermosillo') {$plantas_id="757"; }
        else if($sucursal== 'guaymas') {$plantas_id="2341"; }

        if(!isset($_COOKIE['session'])) {           
            $_COOKIE['session']['sucursal'] = $sucursal;
            $_COOKIE['session']['plantas_id'] = $plantas_id;
        }
        $_SESSION['session']['sucursal'] = $sucursal;
        $_SESSION['session']['plantas_id'] = $plantas_id;
        
        //echo json_encode($_SESSION['session']);
        echo "ok";     
    }
        


}