<?php

class Flash {

    public static function error($error = null) {
        $_SESSION["error"] = $error;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public static function hasError() {
        if (isset($_SESSION["error"])) {
            $error = $_SESSION["error"];
            unset($_SESSION["error"]);
            return $error;
        } else {
            return false;
        }
    }

}

?>