<?php
/**
 * Created by PhpStorm.
 * User: pacorock
 * Date: 23/12/2016
 * Time: 08:24 PM
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/spot.class.php");
require_once($_SITE_PATH . "app/model/usuarios.class.php");
require_once($_SITE_PATH . "app/model/clientes.class.php");

$oSpot = new Spot();
$oSpot->ValidaNivelUsuario("spot");

$oClientes = new Clientes();
$oClientes->cli_activo = 1;

if ($_SESSION[$oClientes->NombreSesion]->usr_nivel == 2) {
    $oClientes->cli_id = $_SESSION[$oClientes->NombreSesion]->cli_id;
}

$lstClientes = $oClientes->Listado();

$oUsuario = new usuarios();
$oUsuario->usr_id = $_SESSION[$oClientes->NombreSesion]->usr_id;

$oUsuario->Informacion();

?>
<?php require_once('app/views/default/script.html'); ?>
<script>
    $(document).ready(function (e) {
        $("#btnBuscar").button().click(function (e) {
            Listado();
        });

        $("#btnAgregar").button().click(function (e) {
            Editar("");
        });
        $("#btnGuardar").click(function (e) {
            if ($("#cli_id").val() == "" || $("#spo_ban").val() == "" || $("#spo_text").val() == "") {
                Alert("", "Llene todos los campos porfavor", "warning");
            }
            else {
                $("#frmFormulario").submit();
            }
        });
        Listado();
    });

    function Editar(id) {
        var jsonDatos = {
            "spo_id": id
        };

        $.ajax({
            data: jsonDatos,
            type: "post",
            url: "app/views/default/modules/spot/text/m.spot.form.php",
            beforeSend: function () {
                $("#divFormulario").html('<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Cargando formulario, espere un momento por favor...</center></div>');
            },
            success: function (datos) {
                $("#divFormulario").html(datos);
            }
        });
        $("#myModal_1").modal({backdrop: ""});
    }

    function Borrar(id) {
        if (confirm("Esta seguro de borrar la información del cliente? Esta acción no se podra deshacer") === false)
            return;

        var jsonDatos = {
            "spo_id": id,
            "accion": "BORRAR"
        };

        $.ajax({
            data: jsonDatos,
            type: "post",
            url: "app/views/default/modules/spot/text/m.spot.procesa.php",
            beforeSend: function () {
            },
            success: function (data) {
                var str = data;
                var datos0 = str.split("@")[0];
                var datos1 = str.split("@")[1];
                var datos2 = str.split("@")[2];
                var datos3 = str.split("@")[3];
                if (datos3 === undefined) {
                    Alert(datos0, datos1, datos2);
                } else {
                    Alert(datos0, datos1 + "  " + datos3, datos2);
                }
                Listado();
            }
        });
    }

    function Listado() {
        var jsonDatos = {
            "cli_nom_empresa": $("#cli_nom_empresa_1").val(),
            "cli_activo": $("#cli_activo_1 option:selected").val(),
        };
        $.ajax({
            data: jsonDatos,
            type: "post",
            url: "app/views/default/modules/spot/text/m.spot.listado.php",
            beforeSend: function () {
                $("#divListado").html(ImagenCargando());
            },
            success: function (datos) {
                $("#divListado").html(datos);
            }
        });
    }
</script>
<!DOCTYPE html PUBLIC >
<html>
    <?php require_once('app/views/default/link.html'); ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html;" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <?php require_once('app/views/default/head.html'); ?>
        <title>SPOT</title>
    </head>
    <style>body {
            padding-top: 70px;
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }</style>
        <?php require_once('app/views/default/menu.php'); ?>
    <div class="container">
        <center>
            <form id="frmOpciones" name="frmOpciones" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2">Nombre del cliente:</label>
                    <div class="col-sm-10">
                        <select id="cli_nom_empresa_1" name="cli_nom_empresa" class="form-control" <?php
                                if ($_SESSION[$oClientes->NombreSesion]->usr_nivel == 1) {
                                    echo "";
                                } else {
                                    echo "disabled";
                                }
                                ?>>
                                    <option value="" selected>--TODOS--</option>
                                    <?php
                                    if (count($lstClientes) > 0) {
                                        foreach ($lstClientes as $idx => $campo) {
                                            if ($campo->cli_id == $oUsuario->cli_id) {
                                                echo "<option value='{$campo->cli_nom_empresa}' selected>{$campo->cli_nom_empresa}</option>\n";
                                            } else {
                                                echo "<option value='{$campo->cli_nom_empresa}'>{$campo->cli_nom_empresa}</option>\n";
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Estado del cliente:</label>
                    <div class="col-sm-10">
                        <select id="cli_activo_1" name="cli_activo" class="form-control">
                            <option value="1">ACTIVO</option>
                            <option value="0">INACTIVO</option>
                            <?php
                            if ($_SESSION[$oSpot->NombreSesion]->usr_nivel == 1) {
                                echo " <option value='T'>-- TODOS --</option>";
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="form-group" style="float:rigth;">
                    <input type="button" class="btn btn-success" id="btnBuscar" name="btnBuscar" value="Buscar">
                    <input type="button" class="btn btn-primary" id="btnAgregar" name="btnAgregar" value="Agregar Spot">
                </div>
            </form>
            <center>
                <hr>
                <!-- Modal -->
                <div class="modal fullscreen-modal fade" id="myModal_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" >
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Informacion de clientes</h4>
                            </div>
                            <div style="width:100%;"  class="modal-body" id="divFormulario" >
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-success" id="btnGuardar" value="Guardar">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div id="divListado"></div>
<?php require_once('app/views/default/footer.php'); ?>
                </div>
