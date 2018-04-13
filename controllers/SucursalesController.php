<?php

Session::logged();

class SucursalesController {

    public function __construct() {
        $this->name = "sucursales";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'sucursal' => new Sucursal(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }

    public function add() {
        include view($this->name . '.add');
    }

    public function edit($id) {
        $data['sucursal'] = $this->model['sucursal']->find($id);
        if (exists($data['sucursal'])) {
            include view($this->name . '.edit');
        }
    }

    public function delete($id) {
        $data['sucursal'] = $this->model['sucursal']->find($id);
        if (exists($data['sucursal'])) {
            include view($this->name . '.delete');
        }
    }

    public function store() {
        $data = validate($_POST, [
            'nombre' => 'required|trimlower|unique:sucursales',
        ]);
        if ($this->model['sucursal']->store($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:sucursales',
            'nombre' => 'required|trimlower|except:sucursales:id',
        ]);
        if ($this->model['sucursal']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:sucursales',
        ]);
        if ($this->model['sucursal']->destroy($data)) {
            Logs::this('Delete','Se elimino la sucursal'.json_encode($data));
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function seleccionar() {
        include view('login.sucursal');        
    }

}
