<?php
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/controllers/mvc.controller.php");
require_once($_SITE_PATH . "app/controllers/mvc.controller_default.php");
require_once($_SITE_PATH . "app/controllers/mvc.controller_administrador.php");

session_start();

$mvc = new mvc_controller();
$action = addslashes(filter_input(INPUT_GET, "action"));

if ($action === "login") {
    $mvc->login();
}else if ($action === "reproductor") {
    $mvc->reproductor();
}else {
    $mvc->ExisteSesion();

    $mvc_default = new mvc_controller_default();

    if ($action === "bienvenida") {// muestra el modulo de bienvenida
        $mvc_default->bienvenida();
    } else if ($action === "clientes") {
        $mvc_admin = new mvc_controller_administrador();
        $mvc_admin->clientes();
    } else if ($action === "usuarios") {
        $mvc_admin = new mvc_controller_administrador();
        $mvc_admin->usuarios();
    }else if ($action === "niveles") {
        $mvc_admin = new mvc_controller_administrador();
        $mvc_admin->niveles();
    } else if ($action === "sugerencias") {
        $mvc_admin = new mvc_controller_administrador();
        $mvc_admin->sugerencias();
    } else if ($action === "buzon_sugerencias") {
        $mvc_default->buzon_sugerencias();
    }else if ($action === "micuenta") {
        $mvc_default->micuenta();
    }else if ($action === "spot") {
        $mvc_default->spot();
    }  else if ($action === "cerrar_sesion") {
        $mvc->CerrarSesion();
    }  else if ($action === "spot_multimedia") {
        $mvc_default->spot_multimedia();
    } else if ($action === "spot_texto") {
        $mvc_default->spot_texto();
    }else if ($action === "acceso_denegado") {
        $mvc->acceso_denegado();
    } else {
        $mvc->error_page();
    }
}
