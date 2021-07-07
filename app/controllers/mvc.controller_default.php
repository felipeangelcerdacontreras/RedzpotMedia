<?php

/*
 * Copyright 2016 - Geodesarrollos Soluciones S de RL de CV
 * francisco.torres@geodesa.com.mx
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/controllers/mvc.controller.php");
require_once($_SITE_PATH . "app/model/Redzpot.class.php");

class mvc_controller_default extends mvc_controller {

    public function __construct() {
        parent::__construct();
        /*
         * Constructor de la clase
         */
    }

    public function bienvenida() {
        include_once("app/views/default/modules/m.bienvenida.php");
    }

    public function usuarios() {
        include_once("app/views/default/modules/preguntas_aclaraciones/m.usuarios.buscar.php");
    }

    public function buzon_sugerencias() {
        include "app/views/default/modules/preguntas_aclaraciones/m.buzon_from.php";
    }

    public function spot() {
        include "app/views/default/modules/spot/text/m.spot.php";
    }
    public function spot_multimedia() {
        include "app/views/default/modules/spot/multimedia/m.multimedia.php";
    }
    public function micuenta()
    {
        include_once("app/views/default/modules/micuenta/m.micuenta.php");
    }

}

?>
