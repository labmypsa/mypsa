<?php

Session::logged();

class LogsController {

    public function __construct() {
        $this->name = "logs";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'log' => new Log(),
        ];
    }

    public function index() {
        include view($this->name . '.read');
    }
}
