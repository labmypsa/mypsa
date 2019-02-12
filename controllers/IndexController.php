<?php

class IndexController {

    public function Index() {

        if (Session::loggedIndex()) {
            $i= substr(Session::get('roles_id'),-1,1); 
            $array_pages= array('?c=login&a=sucursal','','?c=reportes','?c=informes&a=calibrar','?c=informes','?c=clienteinformes','?c=recepcion');
            redirect($array_pages[$i]);
        } else {
            include view('login.index');
            exit;
        }
    }

}