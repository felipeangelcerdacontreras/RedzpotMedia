<?php

/*
 * Copyright 2019 Redzpot 
 * Correo-E: cerda@redzpot.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/usuarios.class.php");

$accion = addslashes(filter_input(INPUT_POST, "accion"));


if ($accion == "GUARDAR") {
    $oUsuarios = new Usuarios(true, $_POST);
    if ($oUsuarios->Guardar() === true) {
        echo "Sistema@Se ha registrado exitosamente la información del usuario. @success";
        if (isset($_FILES["foto"])) {
            if ($oUsuarios->SubirArchivo($_FILES["foto"])) {
                echo "@    Se ha subido el archivo exitosamente";
            }else{
              echo "@     Fallo al subir el archivo";
            }
        }
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información del usuario, vuelva a intentarlo o consulte con el administrador del sistema.@warning";
        // error;
    }
} else if ($accion == "BORRAR") {
    $oUsuarios = new Usuarios(true, $_POST);
    if ($oUsuarios->Borrar() === true) {
        echo "@Se ha borrado la información exitosamente@success";
    } else {
        echo "Sistema@Ha ocurrido un problema al tratar de borrar la información, inténtelo nuevamente o contacte con el administrador del sistema.@warning";
    }
} else if ($accion == "QUITAR_FOTO") {
    $oUsuarios = new Usuarios(true, $_POST);
    $res = $oUsuarios->QuitarFoto();
    if ($res == true) {
        echo "Sistema@Se ha quitado la foto del usuario.@success";
    }
    if ($res == false) {
        echo "Sistema@Ha ocurrido un problema al tratar de quitar la foto, por favor vuelva a intenarlo o consulte con el administrador del sistema.@warning";
    }
}
?>
