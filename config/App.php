<?php

//App config
define("APP_NAME", "<strong>MyPSA</strong> Online");
define("APP_TITLE", "Metrología y Pruebas S.A. de C.V.");
define("APP_VERSION", "2.0.0");
define("APP_TITLE_SIDEBAR", "<strong>M</strong>y<strong>PSA</strong>Online");
define("APP_TITLE_SIDEBAR_SMALL", "<strong>M</strong>y<strong>P</strong>");
define("APP_FOOTER", "<a href='#'>Metrología y Pruebas S.A de C.V.</a>");
define("APP_INIT_YEAR", "2014");


//Production mode
if ($production_mode) {
    define("APP_SERVER",    "192.232.243.186");
    define("APP_USER",      "mypsa_app");
    define("APP_PASS",      "kvkk4bn995");
    define("APP_DB",        "mypsa_bitacoramyp");
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    define("APP_SERVER",    "localhost");
    define("APP_USER",      "root");
    define("APP_PASS",      "");
    define("APP_DB",        "mypsa_bitacoramyp");
}
if($logs){
    define("LOGS", true);
} else{
    define("LOGS", false);
}