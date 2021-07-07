<?php

/*
 * Copyright 2016 Geodesarollo Soluciones S. de R.L. de C.V.
 * Correo-E: francisco.torres@geodesa.com.mx
 */
//require_once ($_SERVER ['DOCUMENT_ROOT'] . "/SOCIAL/app/model/usuarios.class.php");

session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/usuariosCuenta.class.php");

$accion = addslashes(filter_input(INPUT_POST, "accion"));
//foreach ($_POST as $idx => $campo) echo "$idx => $campo<br />";

if ($accion == "GUARDAR") {
    $obj = new Usuarioscuenta(true, $_POST);

    $iResultado = 1;
    if ($obj->Guardar() === true) {
        // exito
        echo "@Se ha registrado exitosamente la información del usuario.@success";
        // si se guardo entonces subo el archivo si es que hay alguno
        if (isset($_FILES["foto"])) {

            $resArchivo = $obj->SubirArchivo($_FILES["foto"]);

            if ($resArchivo === 2) {
                $iResultado = 2;
            } else if ($resArchivo === true) {
                if ($obj->ActualizarRutaFoto() === FALSE)
                    $iResultado = 0;
            }
        }
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información del usuario, vuelva a intentarlo o consulte con el administrador del sistema.@warning";
        // error;
    }
} else if ($accion == "BORRAR") {
    $obj = new Usuarios(true, $_POST);
    if ($obj->Borrar() === true) {
        echo "Sistema@Se ha borrado la información exitosamente@success";
    } else {
        echo "Sistema@Ha ocurrido un problema al tratar de borrar la información, inténtelo nuevamente o contacte con el administrador del sistema.@warning";
    }
} else if ($accion == "QUITAR_FOTO") {
    $obj = new Usuarios(true, $_POST);
    $res = $obj->QuitarFoto();
    if ($res == true) {
        echo "Sistema@Se ha quitado la foto del usuario.@success";
    }
    if ($res == false) {
        echo "Sistema@Ha ocurrido un problema al tratar de quitar la foto, por favor vuelva a intenarlo o consulte con el administrador del sistema.@warning";
    }
}
?>
