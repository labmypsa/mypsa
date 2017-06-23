<?php

Session::logged();

class RolesController {

    public function __construct() {
        $this->name = "roles";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'rol' => new Rol(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }

    public function add() {
        include view($this->name . '.add');
    }

    public function edit($id) {
        $data['rol'] = $this->model['rol']->find($id);
        if (exists($data['rol'])) {
            include view($this->name . '.edit');
        }
    }

    public function delete($id) {
        $data['rol'] = $this->model['rol']->find($id);
        if (exists($data['rol'])) {
            include view($this->name . '.delete');
        }
    }

    public function store() {
        $data = validate($_POST, [
            'nombre' => 'required|trimlower|unique:roles',
        ]);
        if ($this->model['rol']->store($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:roles',
            'nombre' => 'required|trimlower|except:roles:id',
        ]);
        if ($this->model['rol']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:roles',
        ]);
        if ($this->model['rol']->destroy($data)) {
            Logs::this('Delete','Se elimino el rol '.json_encode($data));
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

}
