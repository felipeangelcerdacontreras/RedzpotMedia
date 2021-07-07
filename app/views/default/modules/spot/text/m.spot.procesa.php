<?php
/**
 * Created by PhpStorm.
 * User: pacorock
 * Date: 23/12/2016
 * Time: 10:59 PM
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/clientes.class.php");
require_once($_SITE_PATH . "app/model/spot.class.php");

$accion = filter_input(INPUT_POST, "accion");
$text = filter_input(INPUT_POST, "spo_text");

if ($accion === "GUARDAR"){
    $oSpot = new Spot($_POST);
    if ($oSpot->Guardar() === true){
        echo "Sistema@Se ha registrado la información del cliente exitosamente.@success";

        if (isset($text)) {
            $id = filter_input(INPUT_POST, "cli_id");
             if ($oSpot->CrearTxt($id) === true) {
                echo "@ Se ha subido el archivo exitosamente";
            }else{
              echo "@  Fallo al subir el archivo";
            }
        }
    }
    else{
        echo "Sistema@Error Ha ocurrido un problema al guardar la información del cliente, vuelva intentarlo o consulte con su administrador del sistema.@success@";
  }
}else if ($accion === "BORRAR"){
    $oSpot = new Clientes();
    $oSpot->spo_id = filter_input(INPUT_POST, "spo_id");
    if ($oSpot->Borrar() === true) {
        echo "Sistema@Se ha eliminado la información del cliente exitosamente.@success@";
    } else {
        echo "Sistema@Error Ha ocurrido un problema al eliminar la información del cliente, vuelva intentarlo o consulte con su administrador del sistema.@success@";
    }
}
/*else if ($accion === "QUITAR_LOGO") {
    $oSpot = new Spot();
    $oSpot->spo_id = filter_input(INPUT_POST, "spo_id");
    if ($oSpot->QuitarLogo() === true)
        echo "Sistema@Se ha quitado el logo exitosamente del cliente.@success@";
    else
        echo "Sistema@Ha ocurrido un error al quitar el logotipo, vuelva a intentarlo o consulte con su administrador del sistema.@success@";
}*/
?>
