<?php
/**
 * Created by PhpStorm.
 * User: pacorock
 * Date: 23/12/2016
 * Time: 08:24 PM
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/clientes.class.php");

$oClientes = new Clientes();
$oClientes->ValidaNivelUsuario("clientes");
?>
<?php require_once('app/views/default/script.html'); ?>
<script>
    $(document).ready(function (e) {
        $("#btnGuardar").button().click(function (e) {
            if ($("#cli_nom_empresa").val() === "" || $("#cli_rfc").val() === "" || $("#cli_nom_representante").val() === "" || $("#cli_direccion").val() === "" || $("#cli_correo_empresa").val() === ""
                    || $("#cli_tel_empresa").val() === "" || $("#cli_tel_representante").val() === "" || $("#cli_fecha_vigencia").val() === "" || $("#cli_slogan").val() === "")
            {
                Alert("", "Llene todos los campos porfavor", "warning");
            }
            else {
                $("#frmFormulario").submit();
            }
        });

        $("#btnBuscar").button().click(function (e) {
            Listado();
        });

        $("#btnAgregarCliente").button().click(function (e) {
            Editar("");
        });
        Listado();
    });

    function Editar(id) {
        var jsonDatos = {
            "cli_id": id
        };

        $.ajax({
            data: jsonDatos,
            type: "post",
            url: "app/views/default/modules/catalogos/clientes/m.clientes.form.php",
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
            "cli_id": id,
            "accion": "BORRAR"
        };

        $.ajax({
            data: jsonDatos,
            type: "post",
            url: "app/views/default/modules/catalogos/clientes/m.clientes.procesa.php",
            beforeSend: function () {
            },
            success: function (datos) {
                MessageBox(datos);
                Listado();
            }
        });
    }

    function Listado() {
        var jsonDatos = {
            "cli_nom_empresa": $("#cli_nom_empresa_1").val(),
            "cli_nom_representante": $("#cli_nom_representante_1").val(),
            "cli_activo": $("#cli_activo_1 option:selected").val()
        };
        $.ajax({
            data: jsonDatos,
            type: "post",
            url: "app/views/default/modules/catalogos/clientes/m.clientes.listado.php",
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
        <title>ADMIN</title>
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
                        <input type="text" class="form-control" id="cli_nom_empresa_1" name="cli_nom_empresa" value="" ></td>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Nombre del representante:</label>
                    <div class="col-sm-10">
                        <input type="text" id="cli_nom_representante_1" name="cli_nom_representante" value="" class="form-control" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Estado del cliente:</label>
                    <div class="col-sm-10">
                        <select id="cli_activo_1" name="cli_activo" class="form-control">
                            <option value="1">ACTIVO</option>
                            <option value="0">INACTIVO</option>
                            <option value="T">-- TODOS --</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="float:rigth;">
                    <input type="button" class="btn btn-success" id="btnBuscar" name="btnBuscar" value="Buscar">
                    <input type="button" class="btn btn-primary" id="btnAgregarCliente" name="btnAgregarCliente" value="Agregar Cliente">
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
