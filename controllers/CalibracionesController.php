<?php

Session::logged();

class CalibracionesController {

    public function __construct() {

        $this->name = "calibraciones";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'calibracion' => new Tipocalibracion(),
            'sucursal' => new Sucursal(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }

    public function add() {
        $data['sucursal'] = $this->model['sucursal']->all();
        include view($this->name . '.add');
    }

    public function edit($id) {
        $data['calibracion'] = $this->model['calibracion']->find($id);
        if (exists($data['calibracion'])) {
            $data['sucursal'] = $this->model['sucursal']->all();
            include view($this->name . '.edit');
        }
    }

    public function delete($id) {
        $data['calibracion'] = $this->model['calibracion']->find($id);
        if (exists($data['calibracion'])) {
            $data['sucursal'] = $this->model['sucursal']->all();
            include view($this->name . '.delete');
        }
    }

    public function store() {
        $data = validate($_POST, [
            'sucursales_id' => 'required|number:exists:sucursales:id',
            'nombre' => 'required|ucname',
        ]);
        if ($this->model['calibracion']->store($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:calibraciones',
            'sucursales_id' => 'required|number:exists:sucursales:id',
            'nombre' => 'required|ucname',
        ]);
        if ($this->model['calibracion']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:calibraciones',
        ]);
        if ($this->model['calibracion']->destroy($data)) {
            Logs::this('Delete','Se elimino la calibracion '.json_encode($data));
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

}
