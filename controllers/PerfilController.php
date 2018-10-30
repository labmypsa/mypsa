<?php

Session::logged();

class PerfilController {

    public function __construct() {
        $this->name = "perfil";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'usuario' => new Usuario(),
        ];
    }

    public function index() {
       $data['usuario'] = $this->model['usuario']->find(Session::get('id'));
        if (exists($data['usuario'])) {
            include view($this->name . '.index');
        }
    }

    public function reset_avatar(){
        $data = [
            'id' => Session::get('id'),
            'imagen' => 'default.png'
        ];
        if ($this->model['usuario']->update($data)) {
            if (Session::get('imagen') != 'default.png') {
                Storage::delete('avatares', Session::get('imagen'));
                Session::renew();
            }
            redirect('?c=' . $this->name);
            
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'nombre' => 'required|trimlower',
            'apellido' => 'required|trimlower',
            'puesto' => 'trimlower',
            'telefono' => 'trimlower',
        ]);
        $data['id'] = Session::get('id');
        if ($this->model['usuario']->update($data)) {
            if ($data['id'] == session::get('id')) {
                Session::renew();
            }
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update_avatar() {
        if($avatar = Storage::validate($_FILES['avatar'], [
            'max-size' => 4096,
            'allow_extension' => ['jpg','png'],
            'timestamp' => true,
        ])){
            $data["id"] = Session::get('id');
            $data["imagen"] = $avatar['timestamp_ext'];
            if ($this->model['usuario']->update($data)) {
                Storage::upload_image('avatares',700, $avatar['name'], $avatar['tmp_name']);
                if (Session::get('imagen') != 'default.png') {
                    Storage::delete('avatares', Session::get('imagen'));
                }
                Session::renew();
                redirect('?c=' . $this->name);
            } else {
                Flash::error(setError('002'));
            }
        } else{
            Flash::error(setError('006'));
        }
    }

    public function password() {
        // Session::logged([
        //     'rol' => 'Servicios|allow',
        // ]);
        include view($this->name . '.password');
    }

    public function update_password() {
        $data = validate($_POST, [
            'password' => 'required|min:3',
        ]);
        $data["password"] = Crypt::encrypt($data["password"]);
        $data["id"] = Session::get('id');
        if ($this->model['usuario']->update($data)) {
            Logs::this('Cambio contraseña a: ' . $_POST['password']);
            Session::destroy();
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }
}