<?php

class Session {

    public static function lock(){
        if (isset($_COOKIE['session'])) {
            setcookie('lock', $_COOKIE['session'], time() + 7 * 24 * 3600, '/', null, null, true);
            $_SESSION['lock'] = unserialize($_COOKIE['session']);
            unset($_COOKIE['session']);
            setcookie('session', '', time() - 3600, '/');
        } else if (isset($_SESSION['session'])) {
            $_SESSION['lock'] = $_SESSION['session'];
            unset($_SESSION['session']);
        }
    }
    
    public static function unlock(){
        if (isset($_COOKIE['lock'])) {
            $_SESSION['session'] = unserialize($_COOKIE['lock']);
            setcookie('session', $_COOKIE['lock'], time() + 7 * 24 * 3600, '/', null, null, true);
            unset($_COOKIE['lock']);
            unset($_SESSION['lock']);
            setcookie('lock', '', time() - 3600, '/');
        } else if (isset($_SESSION['lock'])) {
            $_SESSION['session'] = $_SESSION['lock'];
            unset($_SESSION['lock']);
        }
    }

    public static function store($id, $cookie) {
        $model = new Usuario();
        $data = $model->store_session($id)[0];
        if ($cookie) {
            setcookie('session', serialize($data), time() + 7 * 24 * 3600, '/', null, null, true);
        }
        $_SESSION['session'] = $data;
    }
    public static function renew(){
        $model = new Usuario();
        $data = $model->store_session(Session::get('id'))[0];

        if (isset($_COOKIE['session'])) {
            setcookie('session', serialize($data), time() + 7 * 24 * 3600, '/', null, null, true);
        }
        $_SESSION['session'] = $data;
    }

    /* FUNCIONAMIENTO
    *  Retorna valores almacenados en Session o Cookie
    *  Verifica primeramente si hay datos en cookie de lo contrario verifica en session
    * ---------------------------------------------------------------------------------
    * SINTAXIS
    * Retorna arreglo completo de datos: Session::get();
    * Retorna dato en especifico: Session::get('nombre');
    */
    public static function get($value = null) {
        if ($value == null) {
            if (isset($_COOKIE['lock'])) {
                $data = unserialize($_COOKIE['lock']);
                return ($data);
            } else if (isset($_COOKIE['session'])) {
                $data = unserialize($_COOKIE['session']);
                return ($data);
            } else if (isset($_SESSION['lock'])) {
                return $_SESSION['lock'];
            } else {
                return $_SESSION['session'];
            }
        } else {
            if (isset($_COOKIE['lock'])) {
                $data = unserialize($_COOKIE['lock']);
                return ($data[$value]);
            } else if (isset($_COOKIE['session'])) {
                $data = unserialize($_COOKIE['session']);
                return ($data[$value]);
            } else if (isset($_SESSION['lock'])) {
                return $_SESSION['lock'][$value];
            } else {
                return $_SESSION['session'][$value];
            }
        }
    }

    /* FUNCIONAMIENTO 
    * Esta funcion esta definida para control de flujo
    * Remplaza la sentencia IF para verificar si la Session actual contiene (has)
    * O no contiene (hasNot) el valor definido
    * ---------------------------------------------------------------------------
    * SINTAXIS
    * Verifica unico valor: if (Session::has('roles_id','10000')) {}
    * Verifica conjunto de valores: if (Session::has('roles_id',['10000','10003'])) {}
    */
    public static function has($value, $data){
        if(is_array($data)){
            foreach ($data as $key) {
               if(Session::get($value) == $key){
                    return true;
                    break;
               }
            }
        return false;
        } else{
            if(Session::get($value) == $data){
                return true;
            } else{
                return false;
            }
        }
    }

    public static function hasNot($value, $data){
        if(is_array($data)){
            foreach ($data as $key) {
               if(Session::get($value) == $key){
                    return false;
                    break;
               }
            }
        return true;
        } else{
            if(Session::get($value) == $data){
                return false;
            } else{
                return true;
            }
        }
    }

    /* FUNCIONAMIENTO
    *  Esta funcion se usa en IndexController
    *  Para evitar un bucle con la funcion logged
    *  Verifica que no este bloqueado y que exista una session
    */
    public static function loggedIndex() {
        if(isset($_SESSION['lock']) || isset($_COOKIE['lock'])){
            header('location: ?c=login&a=lock');
            exit;
        }
        if (isset($_SESSION['session']) || isset($_COOKIE['session'])) {
            return true;
        } else {
            return false;
        }
    }

    /* FUNCIONAMIENTO
    *  Regresa TRUE si encuentra algo en Cookie o Session
    *  de lo contrario lo manda al index
    */
    private static function isLogued(){
        if (isset($_SESSION['session']) || isset($_COOKIE['session'])) {
            return true;
        } else
            header('location: index.php');
            exit;
    }

    /* FUNCIONAMIENTO
    * Verifica en la Session si el usuario esta activo
    * de lo contrario detruye la session y lo saca del sistema
    */
    private static function isActive(){
        if(Session::get('activo')=='si'){
            return true;
        } else{
            Session::destroy();
        }
    }

    /* FUNCIONAMIENTO
    *  Verifica si el usuario esta logueado con o sin reglas de validacion
    *  Verifica si el usuario esta activo o no
    *  ---------------------------------------------------------------------
    *  SINTAXIS
    *  Valida unicamente Logueo y Activo: Session::logged();
    *  Valida Logue, Activo y que cumpla parametros: Session::logged(['nombre'=>'Maria','apellido'=>'Torres']);
    *  Validacion con mas de una opcion de valor: Session::logged('edad'=>'18|19|20');
    */
    public static function logged($rules = NULL) {
        /* Verificamos primero si el estado de la session se encuentra bloqueado
        *  Ya sea la Session o la Cookie de bloqueo exista
        *  Se mandar a la vista de bloqueo y se termina el proceso 
        */
        if(isset($_SESSION['lock']) || isset($_COOKIE['lock'])){
            header('location: ?c=login&a=lock');
            exit;
        }

        /* Se almacena un log del acceso al sistema
        *  Si no existe la Session log entonces la creamos
        *  Hacemos un log para confirmar que se accedio al sistema
        */
        if (!isset($_SESSION['log'])) {
            $_SESSION['log'] = true;
            Logs::this('access');
        }

        /* Aqui empieza verdaderamente la verificacion de logueo
        *  Verificamos si esta logueado y esta activo el usuario
        *  Si no existen reglas ahi termina la validacion
        *  Si existen reglas seguira el flujo de validacion
        */

        if(Session::isLogued() && Session::isActive()){
            if ($rules == NULL) {
                return true;
            }
        }

        /*
        * $user:  es un arreglo con toda la informacion de la session actual
        * $rules: son los parametros definidos para la comparacion y validacion
        * $rule:  es la regla de la ireaccion actual
        * $value: es el valor de la regla de la iteraccion actual
        * $values: es un arreglo del valor de las iteraciones separado por |
        * $key: es el valor del dato neto que se comprara
        * --------------------------------------------------------------------
        * Se recorre primeramente todos los elementos de las reglas definidas
        * Luego se separa el valor de las reglas divido por | para compararlos con 
        * El valor almacenado en $user
        */
        $user = Session::get();
        $isValid = false;
        foreach ($rules as $rule => $value) {
            $values = explode('|', $value);
            foreach ($values as $key) {
                $isValid = ($user[$rule] == $key) ? true : false;
                if($isValid == true) break;
            }
            if($isValid == false){
                include view('error.403');
                exit;
            }
        }
        // foreach ($rules as $key => $value) {
        //     $value_array = explode('|', $value);
        //     var_dump($session_values);
        //     exit;
        //     if ($value_array[0] != $session_values[$key]) {
        //         if(isset($value_array[1])){
        //             if(isset($_SESSION['auth']['error']))
        //             {
        //                 if($_SESSION['auth']['error'] > 0){
        //                     $_SESSION['auth']['error']--;
        //                     break;
        //                 } else{
        //                     $_SESSION['auth']['key'] = $key;
        //                 $_SESSION['auth']['value'] = $value_array[0];
        //                 $_SESSION['auth']['url'] = $_SERVER['REQUEST_URI'];
        //                 include view('admin.access');
        //                 exit;
        //                 }
        //             } else{
        //                 $_SESSION['auth']['key'] = $key;
        //                 $_SESSION['auth']['value'] = $value_array[0];
        //                 $_SESSION['auth']['url'] = $_SERVER['REQUEST_URI'];
        //                 include view('admin.access');
        //                 exit;
        //             }
        //         }
        //         include view('error.403');
        //         exit();
        //     }
        // }
    // } else {
    //     header('location: index.php');
    // }
        }

    /* FUNCIONAMIENTO
    *  Realiza un log de que se cerro la sesion
    *  Elimina el valor almacenado en todas las variables de session y cookies
    *  Destruye la session y reedirige al usuario al index
    */
    public static function destroy() {
        Logs::this('logout');
        unset($_SESSION['session']);
        unset($_SESSION['lock']);
        session_destroy();
        unset($_COOKIE['session']);
        unset($_COOKIE['lock']);
        setcookie('session', '', time() - 3600, '/');
        setcookie('lock', '', time() - 3600, '/');
        header('location:index.php');
    }
}