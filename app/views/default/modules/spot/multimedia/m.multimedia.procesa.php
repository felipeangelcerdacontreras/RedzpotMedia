<?php
/**
 * Created by Visual Code.
 * User: ADMINC4
 * Date: 26/06/2019
 * Time: 10:59 PM
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/multimedia.class.php");

$accion = addslashes(filter_input(INPUT_POST, "accion"));

$final = addslashes(filter_input(INPUT_POST, "final"));

//foreach ($_POST as $idx => $campo) echo "$idx => $campo<br />";

if ($accion == "GUARDAR") {
    $oMulti = new Multimedia(true, $_POST);

    if ($oMulti->Guardar() === true) {
        // exito
        echo "@Se ha registrado exitosamente la información del usuario.@success";
        // si se guardo entonces subo el archivo si es que hay alguno
        if (isset($_FILES["foto"])) {
            if ($oMulti->SubirArchivo($_FILES["foto"])) {
                echo "@ Se ha subido el archivo exitosamente";
            }else{
              echo "@ Fallo al subir el archivo";
            }
        }
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información del usuario, vuelva a intentarlo o consulte con el administrador del sistema.@warning";
        // error;
    }
} else if ($accion == "BORRAR") {
    $oMulti = new Multimedia(true, $_POST);
    if ($oMulti->Borrar() === true) {
        echo "Sistema@Se ha borrado la información exitosamente@success";
    } else {
        echo "Sistema@Ha ocurrido un problema al tratar de borrar la información, inténtelo nuevamente o contacte con el administrador del sistema.@warning";
    }
} else if ($accion == "QUITAR") {
    $oMulti = new Multimedia(true, $_POST);
    $res = $oMulti->Quitar();
    if ($res == true) {
        echo "Sistema@Se ha quitado la foto del usuario.@success";
    }
    if ($res == false) {
        echo "Sistema@Ha ocurrido un problema al tratar de quitar la foto, por favor vuelva a intenarlo o consulte con el administrador del sistema.@warning";
    }
}else if ($accion == "LISTA"){
    $oMulti = new Multimedia(true, $_POST);
    $res = 1;
    $i = 1;
    $res2 = 1;
    $numRow = $final-1;
    if ($numRow > 0){
    for ($i = 1; $i <= $numRow; $i++) {
        $id = addslashes(filter_input(INPUT_POST, "id_".$i));
        $orden = addslashes(filter_input(INPUT_POST, "orden_".$i));
        $cli_id = addslashes(filter_input(INPUT_POST, "cli_id_".$i));
        //update de orden
        $oMulti->GenerarLista($id ,$orden);
        $res2++;
    }
    if ($i == $res2) {
        //echo "@Se ha registrado exitosamente el orden.@success@";
        $datos = '';
        foreach ($oMulti->CrearTxt($cli_id) as $idx => $campo) {      
        if ($campo->mul_tipo == 'MP4') {
                $datos = "<li><video preload='none' muted src = '$campo->mul_ruta' ></video></li>";
                }
                if ($campo->mul_tipo != 'MP4') {
                    $datos ="<li><img src = '$campo->mul_ruta' /></li>";
                }
                 echo $datos;
            } 
            echo "@".$cli_id;
    }
}else{
        echo "";
    }
}else if ($accion == "TXT"){
    $oMulti = new Multimedia(true, $_POST);

    $id = addslashes(filter_input(INPUT_POST, "id"));
    $texto = addslashes(filter_input(INPUT_POST, "texto"));
    //echo "$id";
    if($id == ""){
        echo "@La lista esta vacia.@warning"; 
    }else{
    if ($oMulti->GeneraTxt($id ,$texto) === true) {
        echo "@Se ha creado la lista correctamente.@success";
        }
        else{
            echo "Ups!@No se a generado la lista.@warning";
        }
  }
}
?>