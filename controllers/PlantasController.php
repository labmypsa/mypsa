<?php

Session::logged();

class PlantasController {

    public function __construct() {
        $this->name = "plantas";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'planta' => new Planta(),
            'empresa' => new Empresa(),
            'ciudad' => new Ciudad(),
            'sucursal' => new Sucursal(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }

    public function find_by($id, $key) {
        return $this->read_single_by($id, $key);
    }

    public function add() {
        $data['empresa'] = $this->model['empresa']->all();
        $data['ciudad'] = $this->model['ciudad']->all();
        $data['sucursal'] = $this->model['sucursal']->all();
        include view($this->name . '.add');
    }

    public function edit($id) {
        $data['planta'] = $this->model['planta']->find($id);
        if (exists($data['planta'])) {
            $data['empresa'] = $this->model['empresa']->all();
            $data['ciudad'] = $this->model['ciudad']->all();
            $data['sucursal'] = $this->model['sucursal']->all();
            include view($this->name . '.edit');
        }
    }

    public function delete($id) {
        $data['planta'] = $this->model['planta']->find($id);
        if (exists($data['planta'])) {
            $data['empresa'] = $this->model['empresa']->all();
            $data['ciudad'] = $this->model['ciudad']->all();
            $data['sucursal'] = $this->model['sucursal']->all();
            include view($this->name . '.delete');
        }
    }

    public function store() {
        $data = validate($_POST, [
            'nombre' => 'required|ucname',
            'empresas_id' => 'required|number|exists:empresas:id',
            'ciudades_id' => 'required|number|exists:ciudades:id',
            'sucursales_id' => 'required|number|exists:sucursales:id',
            'rfc'=> 'ucname',
            'razon_social'=> 'ucname',
            'direccion'=> 'required|ucname',           
        ]);
        if ($this->model['planta']->store($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:plantas',
            'nombre' => 'required|ucname',
            'empresas_id' => 'required|number|exists:empresas:id',
            'ciudades_id' => 'required|number|exists:ciudades:id',
            'sucursales_id' => 'required|number|exists:sucursales:id',
            'rfc'=> 'ucname',
            'razon_social'=> 'ucname',
            'direccion'=> 'required|ucname',
        ]);
        if ($this->model['planta']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:plantas',
        ]);
        if ($this->model['planta']->destroy($data)) {
            Logs::this('Delete','Se elimino el cliente '.json_encode($data));
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

}
