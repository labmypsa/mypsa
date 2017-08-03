<?php

Session::logged();

class Equipos_modelosController {

    public function __construct() {
        $this->name = "equipos_modelos";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'equipos_modelos' => new EquipoModelo(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }

    public function add() {

        include view($this->name . '.add');
    }

    public function edit($id) {
        $data['equipos_modelos'] = $this->model['equipos_modelos']->find($id);
        if (exists($data['equipos_modelos'])) {
            include view($this->name . '.edit');
        }
    }

    public function delete($id) {
        $data['equipos_modelos'] = $this->model['equipos_modelos']->find($id);
        if (exists($data['equipos_modelos'])) {
            include view($this->name . '.delete');
        }
    }

    public function store() {
        $data = validate($_POST, [
            'nombre' => 'required|strtoupper|unique:equipos_modelos',
        ]);
        if ($this->model['equipos_modelos']->store($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:equipos_modelos',
            'nombre' => 'required|strtoupper|except:equipos_modelos:id',
        ]);
        if ($this->model['equipos_modelos']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:equipos_modelos',
        ]);
        if ($this->model['equipos_modelos']->destroy($data)) {
            Logs::this('Delete','Se elimino un modelo '.json_encode($data));
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

}
