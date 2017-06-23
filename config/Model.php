<?php

class Model extends Db {

    public function search($str, $columns, $view = null){
        if ($view == null) {
            return $this->like($str, $columns);
        } else {
            return $this->like($str, $columns, $view);
        }
    }

    public function all($view = null) {
        if ($view == null) {
            return $this->read();
        } else {
            return $this->read($view);
       } 
    }

    public function find($id, $view = null) {
        if ($view == null) {
            return $this->read_single($id);
        } else {
            return $this->read_single($id, $view);
        }
    }

    public function find_by($data, $view = null) {
        if ($view == null) {
            return $this->read_single_by($data);
        } else {
            return $this->read_single_by($data, $view);
        }
    }

    public function store($data) {
        return $this->insert($data);
    }

    public function update($data) {
        return $this->edit($data);
    }

    public function destroy($data) {
        return $this->delete($data);
    }

}
