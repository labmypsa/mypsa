<?php

Session::logged();

class AcreditacionesController {

    public function __construct() {
        $this->name = "acreditaciones";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->models = [
            'acreditacion' => new Acreditacion(),
            'sucursal' => new Sucursal(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }

    public function add() {
        $data['sucursal'] = $this->models['sucursal']->all();
        include view($this->name . '.add');
    }

    public function edit($id) {
        $data['acreditacion'] = $this->models['acreditacion']->find($id);
        if (exists($data['acreditacion'])) {
            $data['sucursal'] = $this->models['sucursal']->all();
            include view($this->name . '.edit');
        }
    }

    public function delete($id) {
        $data['acreditacion'] = $this->models['acreditacion']->find($id);
        if (exists($data['acreditacion'])) {
            $data['sucursal'] = $this->models['sucursal']->all();
            include view($this->name . '.delete');
        }
    }

    public function store() {
        $data = validate($_POST, [
            'sucursales_id' => 'required|number|exists:sucursales:id',
            'nombre' => 'required|ucname',
            'activo' => 'required|toInt',
        ]);
        if ($this->models['acreditacion']->store($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:acreditaciones',
            'sucursales_id' => 'required|number|exists:sucursales:id',
            'nombre' => 'required|ucname',
            'activo' => 'required|toInt',
        ]);
        if ($this->models['acreditacion']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:acreditaciones',
        ]);
        if ($this->models['acreditacion']->destroy($data)) {
            Logs::this('Delete','Se elimino la acreditación '.json_encode($data));
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

}
//