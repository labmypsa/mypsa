<?php

function view($view) {
    $path = 'views/';
    $arrayData = explode('.', $view);
    foreach ($arrayData as $key) {
        $path .= $key . '/';
    }
    $path = substr($path, 0, -1);
    $path .= '.php';
    return $path;
}
