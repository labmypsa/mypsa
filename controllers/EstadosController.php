<?php

Session::logged();

class EstadosController {

    public function __construct() {
        $this->name = "estados";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'estado' => new Estado(),
            'pais' => new Pais(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }

    public function add() {
        $data['pais'] = $this->model['pais']->all();
        include view($this->name . '.add');
    }

    public function edit($id) {
        $data['estado'] = $this->model['estado']->find($id);
        if (exists($data['estado'])) {
            $data['pais'] = $this->model['pais']->all();
            include view($this->name . '.edit');
        }
    }

    public function delete($id) {
        $data['estado'] = $this->model['estado']->find($id);
        if (exists($data['estado'])) {
            $data['pais'] = $this->model['pais']->all();
            include view($this->name . '.delete');
        }
    }

    public function store() {
        $data = validate($_POST, [
            'nombre' => 'required|trimlower',
            'paises_id' => 'required|number|exists:paises:id',
        ]);
        if ($this->model['estado']->store($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:estados',
            'nombre' => 'required|trimlower',
            'paises_id' => 'required|number|exists:paises:id',
        ]);
        if ($this->model['estado']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:estados',
        ]);
        if ($this->model['estado']->destroy($data)) {
            Logs::this('Delete','Se elimino el estado '.json_encode($data));
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

}
