<?php
/*
 * Copyright 2016 Geodesarollo Soluciones S. de R.L. de C.V.
 * Correo-E: francisco.torres@geodesa.com.mx
 */
session_start();
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/niveles.class.php");

$accion = addslashes(filter_input(INPUT_POST, "accion"));
//foreach ($_POST as $idx => $campo) echo "$idx => $campo<br />";

if ($accion === "GUARDAR") {
    $obj = new Niveles(true, $_POST);

    $iResultado = 1;
    if ($obj->Guardar() === true) {
        // exito
        echo "@Se ha registrado exitosamente la información del nivel.@success";
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información del usuario, vuelva a intentarlo o consulte con el administrador del sistema.@warning";
        // error;
    }
} else if ($accion === "BORRAR") {
    $obj = new Niveles(true, $_POST);
    if ($obj->Borrar() === true) {
        echo "@Se ha borrado la información exitosamente.@success";
    } else {
        echo "Sistema@Ha ocurrido un problema al tratar de borrar la información, inténtelo nuevamente o contacte con el administrador del sistema.@warning";
    }
}
?>
