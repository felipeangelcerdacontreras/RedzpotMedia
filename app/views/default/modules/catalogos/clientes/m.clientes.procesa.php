<?php
/**
 * Created by NetBeans.
 * User: ADMINC4
 * Date: 19/06/2019
 * Time: 10:59 PM
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/clientes.class.php");

$accion = filter_input(INPUT_POST, "accion");

if ($accion === "GUARDAR"){
    $oCliente = new Clientes($_POST);
    if ($oCliente->Guardar() === true){
        echo "Sistema@Se ha registrado la información del cliente exitosamente.@success";
        if (isset($_FILES["foto"])) {
            if ($oCliente->SubirArchivo($_FILES["foto"])) {
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
    $oCliente = new Clientes();
    $oCliente->cli_id = filter_input(INPUT_POST, "cli_id");
    if ($oCliente->Borrar() === true){
        echo "Sistema@Se ha eliminado la información del cliente exitosamente.@success@";
    }
    else
        echo "Sistema@Error Ha ocurrido un problema al eliminar la información del cliente, vuelva intentarlo o consulte con su administrador del sistema.@success@";
}
else if ($accion === "QUITAR_LOGO") {
    $oCliente = new Clientes();
    $oCliente->cli_id = filter_input(INPUT_POST, "cli_id");
    if ($oCliente->QuitarLogo() === true)
        echo "Sistema@Se ha quitado el logo exitosamente del cliente.@success@";
    else
        echo "Sistema@Ha ocurrido un error al quitar el logotipo, vuelva a intentarlo o consulte con su administrador del sistema.@success@";
}
?>
