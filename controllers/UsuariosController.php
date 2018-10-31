<?php

Session::logged();

class UsuariosController {

    public function __construct() {
        $this->name = "usuarios";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'usuario' => new Usuario(),
            'rol' => new Rol(),
            'empresa' => new Empresa(),
            'sucursal' => new Sucursal(),
            'planta' => new Planta(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }

    public function alta() {
        include view($this->name . '.alta');
    }

    public function refresh() {
        Session::renew();
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function turn_off($id){
        $data['usuario'] = $this->model['usuario']->find($id);
        if (exists($data['usuario'])) {  
            if (intval($data['usuario'][0]['roles_id']) == 10000 and Session::get("rol") != "Administrador") {
                        redirect('?c=error&a=error_403');
            }
            else{
                $disponible = $data['usuario'][0]['activo'];
                $data['id'] = $id;
                if($disponible == 1){
                    $data['activo'] = 0;
                } else{
                    $data['activo'] = 1;
                }
                unset($data['usuario']);
                if ($this->model['usuario']->update($data)) {
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    Flash::error(setError('002'));
                }
            }
        }
    }

    public function add() {
        //var_dump(Session::get("rol")); //Administrador         
        $data['rol'] = $this->model['rol']->all();
        $data['empresa'] = $this->model['empresa']->all();
        include view($this->name . '.add');
    }

    public function edit($id) {
        $data['usuario'] = $this->model['usuario']->find($id);
        //var_dump($data['usuario'][0]['roles_id']);
        if (exists($data['usuario'])) {  
            if (intval($data['usuario'][0]['roles_id']) == 10000 and Session::get("rol") != "Administrador") {
                        redirect('?c=error&a=error_403');
            }
            else{
            $plantas_id = $data['usuario'][0]['plantas_id'];
            $empresa = $this->model['planta']->find_by(['id'=>$plantas_id]);
            $empresas_id = $empresa[0]['empresas_id'];
            $data['empresa'] = $this->model['empresa']->all();
            $data['planta'] = $this->model['planta']->find_by(['empresas_id'=>$empresas_id]);
            $data['rol'] = $this->model['rol']->all();
            include view($this->name . '.edit');
            }         
            
        }
    }

    public function delete($id) {
        $data['usuario'] = $this->model['usuario']->find($id);
        if (exists($data['usuario'])) {
            if (intval($data['usuario'][0]['roles_id']) == 10000 and Session::get("rol") != "Administrador") {
                redirect('?c=error&a=error_403');
            }
            else{
                $idplanta = $data['usuario'][0]['plantas_id'];
                $empresa = $this->model['planta']->find_by(['id'=>$idplanta]);
                $idempresa = $empresa[0]['empresas_id'];
                $data['empresa'] = $this->model['empresa']->all();
                $data['planta'] = $this->model['planta']->find_by(['empresas_id'=>$idempresa]);
                $data['rol'] = $this->model['rol']->all();
                include view($this->name . '.delete');
            }
        }
    }

    public function store() {
        $data = validate($_POST, [
            'nombre' => 'required|ucwords',
            'apellido' => 'required|ucwords',
            'plantas_id' => 'required|trimlower|exists:plantas:id',
            'email' => 'required|trimlower|unique:usuarios',
            'password' => 'required',
            'roles_id' => 'required|trimlower|exists:roles:id',
            'activo' => 'required|toInt',
        ]);
        
        $data["nombre"] = ucfirst($data["nombre"]);
        $data["apellido"] = ucfirst($data["apellido"]);
        $data["password"] = Crypt::encrypt($data["password"]);
        if($_FILES['avatar']['size'] > 0){
            if($avatar = Storage::validate($_FILES['avatar'], [
                'max-size' => 4096,
                'allow_extension' => ['jpg','png'],
                'timestamp' => true,
            ])){
                $data["imagen"] = $avatar['timestamp_ext'];
                if ($this->model['usuario']->store($data)) {
                    Storage::upload_image('avatares',700, $avatar['name'], $avatar['tmp_name']);
                    redirect('?c=' . $this->name);
                } else {
                    Flash::error(setError('002'));
                }
            } else{
                Flash::error(setError('006'));
            }
         } else{
            if ($this->model['usuario']->store($data)) {
                if(Session::get('id') == $data['id']){
                    Session::renew();
                }
                redirect('?c=' . $this->name);
            } else {
                Flash::error(setError('002'));
            }
        }
    }

    public function update() {
        
        $data = validate($_POST, [
            'id' => 'required|exists:usuarios',
            'nombre' => 'required|ucwords',
            'apellido' => 'required|ucwords',
            'email' => 'required|trimlower',
            'plantas_id' => 'required|trimlower|exists:plantas:id',
            'roles_id' => 'required|trimlower|exists:roles:id',
            'activo' => 'required|toInt',
        ]);
        /* ..................................... */
        /*      Envio de notificacion            */
        /* ..................................... */
        if (isset($_POST['check_email'])) {

            $dataemail['nombre']=$data['nombre'];
            $dataemail['apellido']=$data['apellido'];
            $dataemail['email']=$data['email'];
            $dataemail['body']=EnvioCorreo::_bodyusernotificacion($dataemail);                                     
            $dataemail['cco'] = array(
                                'email' => array('it@mypsa.mx','mvega@mypsa.mx'), 
                                'alias' => array('Sistema','Manuel V.'),                       
                            );                                

            $dataemail['asunto']="Usuario de alta MyPSA";            
            EnvioCorreo::_enviocorreo($dataemail);            
        } 
        unset($data['check_email']);
        $data["nombre"] = ucfirst($data["nombre"]);
        $data["apellido"] = ucfirst($data["apellido"]);
        if($_FILES['avatar']['size'] > 0){
            if($avatar = Storage::validate($_FILES['avatar'], [
                'max-size' => 4096,
                'allow_extension' => ['jpg','png'],
                'timestamp' => true,
            ])){
                $data["imagen"] = $avatar['timestamp_ext'];
                if ($this->model['usuario']->update($data)) {
                    Storage::upload_image('avatares',700, $avatar['name'], $avatar['tmp_name']);
                    if ($_POST['imagen'] != 'default.png') {
                        Storage::delete('avatares', $_POST['imagen']);
                    }
                    if(Session::get('id') == $data['id']){
                        Session::renew();
                    }
                    redirect('?c=' . $this->name);
                } else {
                    Flash::error(setError('002'));
                }
            } else{
                Flash::error(setError('006'));
            }
        } else{    
            if ($this->model['usuario']->update($data)) {
                if(Session::get('id') == $data['id']){
                    Session::renew();
                }
                redirect('?c=' . $this->name);
            } else {
                Flash::error(setError('002'));
            }
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|exists:usuarios',
        ]);
        if ($this->model['usuario']->destroy($data)) {
            Logs::this('Delete','Se elimino el usuario '.json_encode($data));
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function ajax_load_plantas() {
        $idempresa = $_POST['empresas_id'];
        echo $data = json_encode($data['planta'] = $this->model['planta']->find_by(['empresas_id'=> $idempresa]));
    }

    public function password($id) {
        $data['usuario'] = $this->model['usuario']->find($id);
         if (intval($data['usuario'][0]['roles_id']) == 10000 and Session::get("rol") != "Administrador") {
                        redirect('?c=error&a=error_403');
            }
            else{
                include view($this->name . '.password');
            }   
    }

    public function update_password() {
        $data = validate($_POST, [
            'id'    => 'required|exists:usuarios',
            'password'  => 'required|min:3',
        ]);
        $data["password"] = Crypt::encrypt($data["password"]);
        if ($this->model['usuario']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function get_usuario_alta(){
        echo $data = json_encode($data['usuario'] = $this->model['usuario']->usuario_alta_notification());
    }


}
