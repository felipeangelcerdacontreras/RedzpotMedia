<?php

/*
 * Copyright 2016 Geodesarollo Soluciones S. de R.L. de C.V.
 * Correo-E: francisco.torres@geodesa.com.mx
 */
require_once ($_SERVER ['DOCUMENT_ROOT'] . "/geodesk/app/model/usuarios.class.php");

$accion = filter_input ( INPUT_POST, "accion" );
// foreach ($_POST as $idx => $campo) echo "$idx => $campo<br />";

if ($accion == "GUARDAR") {
    $obj = new usuarios(true, $_POST);

    $iResultado = 1;
    if ($obj->Guardar() === true) {
        // exito
        $iResultado = 1;

        // si se guardo entonces subo el archivo si es que hay alguno
        if (isset($_FILES["foto"])) {
            
            $resArchivo = $obj->SubirArchivo($_FILES["foto"]);

            if ($resArchivo === 2) {
                $iResultado = 2;
            }
            else if ($resArchivo === true) {
                if ($obj->ActualizarRutaFoto() === FALSE)
                    $iResultado = 0;
            }
        }
        echo "Se ha registrado la información exitosamente";
    }
    else {
        $iResultado = 0;
        // error;
    }

    //header("Location: ../../../../../index.php?action=catalogo_usuarios&r={$iResultado}");
    //exit();
}
else if ($accion == "BORRAR") {
    $obj = new usuarios(true, $_POST);
    if ($obj->Borrar() === true) {
        echo $obj->MensajeAviso("Sistema", "Se ha borrado la información exitosamente");
    }
    else {
        echo $obj->MensajeAlerta("Sistema", "Ha ocurrido un problema al tratar de borrar la información, inténtelo nuevamente o contacte con el administrador del sistema.");
    }
}
else if ($accion == "QUITAR_FOTO") {
    $obj = new usuarios(true, $_POST);
    $res = $obj->QuitarFoto();
    if ($res == true) {
        echo $obj->MensajeAviso("Sistema:", "Se ha quitado la foto del usuario.");
    }
    if ($res == false) {
        echo $obj->MensajeAlerta("Sistema:", "Ha ocurrido un problema al tratar de quitar la foto, por favor vuelva a intenarlo o consulte con el administrador del sistema.");
    }
}
?>