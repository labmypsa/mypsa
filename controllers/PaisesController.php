<?php

Session::logged();

class PaisesController {

    public function __construct() {
        $this->name = "paises";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'pais' => new Pais(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }

    public function add() {
        include view($this->name . '.add');
    }

    public function edit($id) {
        $data['pais'] = $this->model['pais']->find($id);
        if (exists($data['pais'])) {
            include view($this->name . '.edit');
        }
    }

    public function delete($id) {
        $data['pais'] = $this->model['pais']->find($id);
        if (exists($data['pais'])) {
            include view($this->name . '.delete');
        }
    }

    public function store() {
        $data = validate($_POST, [
            'nombre' => 'required|trimlower|unique:paises',           
        ]);
        if ($this->model['pais']->store($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:paises',
            'nombre' => 'required|trimlower|except:paises:id',
        ]);
        if ($this->model['pais']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:paises',
        ]);
        if ($this->model['pais']->destroy($data)) {
            Logs::this('Delete','Se elimino el pais'.json_encode($data));
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

}
