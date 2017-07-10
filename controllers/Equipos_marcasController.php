<?php

Session::logged();

class Equipos_marcasController {

    public function __construct() {
        $this->name = "equipos_marcas";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'equipos_marcas' => new EquipoMarca(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }

    public function add() {
        include view($this->name . '.add');
    }

    public function edit($id) {
        $data['equipos_marcas'] = $this->model['equipos_marcas']->find($id);
        if (exists($data['equipos_marcas'])) {
            include view($this->name . '.edit');
        }
    }

    public function delete($id) {
        $data['equipos_marcas'] = $this->model['equipos_marcas']->find($id);
        if (exists($data['equipos_marcas'])) {
            include view($this->name . '.delete');
        }
    }

    public function store() {
        $data = validate($_POST, [
            'nombre' => 'required|ucname|unique:equipos_marcas',
        ]);
        if ($this->model['equipos_marcas']->store($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:equipos_marcas',
            'nombre' => 'required|ucname|except:equipos_marcas:id',
        ]);
        if ($this->model['equipos_marcas']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:equipos_marcas',
        ]);
        if ($this->model['equipos_marcas']->destroy($data)) {
            Logs::this('Delete','Se elimino una marca '.json_encode($data));
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

}
