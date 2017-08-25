<?php

Session::logged();

class CiudadesController {

    public function __construct() {
        $this->name = "ciudades";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'ciudad' => new Ciudad(),
            'estado' => new Estado(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }
    public function test(){
        include view($this->name . '.index');
    }
    public function add() {
        $data['estado'] = $this->model['estado']->all();
        include view($this->name . '.add');
    }

    public function edit($id) {
        $data['ciudad'] = $this->model['ciudad']->find($id);
        if (exists($data['ciudad'])) {
            $data['estado'] = $this->model['estado']->all();
            include view($this->name . '.edit');
        }
    }

    public function delete($id) {
        $data['ciudad'] = $this->model['ciudad']->find($id);
        if (exists($data['ciudad'])) {
            $data['estado'] = $this->model['estado']->all();
            include view($this->name . '.delete');
        }
    }

    public function store() {
        $data = validate($_POST, [
            'estados_id' => 'required|number|exists:estados:id',
            'nombre' => 'required|ucname',
        ]);
        if ($this->model['ciudad']->store($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:ciudades',
            'estados_id' => 'required|number|exists:estados:id',
            'nombre' => 'required|ucname',
        ]);
        if ($this->model['ciudad']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:ciudades',
        ]);
        if ($this->model['ciudad']->destroy($data)) {
            Logs::this('Delete','Se elimino la acreditación '.json_encode($data));
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

}
