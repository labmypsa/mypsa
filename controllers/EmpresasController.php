<?php

Session::logged();

class EmpresasController {

    public function __construct() {
        $this->name = "empresas";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'empresa' => new Empresa(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }

    public function add() {
        include view($this->name . '.add');
    }

    public function edit($id) {
        $data['empresa'] = $this->model['empresa']->find($id);
        if (exists($data['empresa'])) {
            include view($this->name . '.edit');
        }
    }

    public function delete($id) {
        $data['empresa'] = $this->model['empresa']->find($id);
        if (exists($data['empresa'])) {
            include view($this->name . '.delete');
        }
    }

    public function store() {
        $data = validate($_POST, [
            'nombre' => 'required|ucname|unique:empresas',
        ]);
        if ($this->model['empresa']->store($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:empresas',
            'nombre' => 'required|ucname|except:empresas:id',
        ]);
        if ($this->model['empresa']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:empresas',
        ]);
        if ($this->model['empresa']->destroy($data)) {
            Logs::this('Delete','Se elimino la empresa '.$data);
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

}
