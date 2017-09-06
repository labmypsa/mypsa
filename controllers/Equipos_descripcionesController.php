<?php
Session::logged();

class Equipos_descripcionesController{

    public function __construct() {
        $this->name = "equipos_descripciones";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'equipos_descripciones' => new EquipoDescripcion(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }

    public function add() {
        include view($this->name . '.add');
    }

    public function edit($id) {
        $data['equipos_descripciones'] = $this->model['equipos_descripciones']->find($id);
        if (exists($data['equipos_descripciones'])) {
            include view($this->name . '.edit');
        }
    }

    public function delete($id) {
        $data['equipos_descripciones'] = $this->model['equipos_descripciones']->find($id);
        if (exists($data['equipos_descripciones'])) {
            include view($this->name . '.delete');
        }
    }

    public function store() {
        $data = validate($_POST, [
            'nombre' => 'required|unique:equipos_descripciones',
        ]);
        if ($this->model['equipos_descripciones']->store($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:equipos_descripciones',
            'nombre' => 'required|except:equipos:id',
        ]);
        if ($this->model['equipos_descripciones']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:equipos_descripciones',
        ]);
        if ($this->model['equipos_descripciones']->destroy($data)) {
            Logs::this('Delete','Se elimino una descripcion '.json_encode($data));
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

}
