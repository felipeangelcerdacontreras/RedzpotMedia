<?php
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/clientes.class.php");
require_once($_SITE_PATH . "app/model/usuarios.class.php");

$oUsuarios = new Usuarios();
$oUsuarios->ValidaNivelUsuario("usuarios");


$oClientes = new Clientes();

if ($_SESSION[$oClientes->NombreSesion]->usr_nivel > 2) {
    $oClientes->cli_id = $_SESSION[$oClientes->NombreSesion]->cli_id;
    $oUsuario->usr_id = $_SESSION[$oClientes->NombreSesion]->usr_id;
}
/* if ($_SESSION[$oClientes->NombreSesion]->usr_nivel == 1) {
  $oClientes->cli_id = $_SESSION[$oClientes->NombreSesion]->cli_id;
  } */

$lstClientes = $oClientes->Listado();
?>
<?php require_once('app/views/default/script.html'); ?>
<script type="text/javascript">
    $(document).ready(function (e) {
        Listado();
        $("#cli_id1, #usr_alias1").keyup(function (event) {
            var tecla = event.keyCode;
            if (tecla === 13) {
                Listado();
            }
        });
        $("#btnBuscar").click(function (e) {
            Listado();
        });
        $("#btnAgregarNuevo").click(function (e) {
            Editar("");
        });

        $("#txtNombre").keyup(function (event) {
            if (event.which === 13) {
                Listado();
            }
        });
        $("#btnGuardar").button().click(function (e) {
            if ($("#cli_id").val() === "0" || $("#usr_alias").val() === "" || $("#usr_nombre").val() === "" || $("#usr_nivel").val() === "0" || $("#usr_correoe").val() === "") {
                Alert("", "Llene todos los campos porfavor", "warning");
            }
            else {
                $("#frmFormulario").submit();
            }
        });

    });

    function Listado() {
        var jsonDatos = {
            "cli_id": $("#cli_id1 option:selected").val(),
            "usr_alias": $("#usr_alias1").val(),
            "accion": "BUSCAR"
        };
        $.ajax({
            data: jsonDatos,
            type: "POST",
            url: "app/views/default/modules/catalogos/usuarios/m.usuarios.listado.php",
            beforeSend: function () {
                $("#divListado").html('<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Leyendo información de la Base de Datos, espere un momento por favor...</center></div>');
            },
            success: function (datos) {
                $("#divListado").html(datos);
            }
        });
    }

    function Editar(usr_id) {
        $.ajax({
            data: "usr_id=" + usr_id,
            type: "POST",
            url: "app/views/default/modules/catalogos/usuarios/m.usuarios.formulario.php",
            beforeSend: function () {
                $("#divFormulario").html('<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Cargando formulario, espere un momento por favor...</center></div>');
            },
            success: function (datos) {
                $("#divFormulario").html(datos);
            }
        });
        $("#myModal_1").modal({backdrop: ""});
    }

    function Borrar(usr_id) {
        if (confirm("¿Está seguro de borrar el registro seleccionado?") == false)
            return;

        $.ajax({
            data: "usr_id=" + usr_id + "&accion=BORRAR",
            type: "POST",
            url: "app/views/default/modules/catalogos/usuarios/m.usuarios.procesa.php",
            beforeSend: function () {
                $("#divListado").html('<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Leyendo información de la Base de Datos, espere un momento por favor...</center></div>');
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
            <div class="form-group">
                <label class="control-label col-sm-1">Cliente:</label>
                <div class="col-sm-20">
                    <select id="cli_id1" name="cli_id1" class="form-control" >
                                    <?php
                                    if (count($lstClientes) > 0) {
                                        if ($_SESSION[$oClientes->NombreSesion]->usr_nivel == 1) {
                                            echo "<option value='' selected>--TODOS--</option>\n";
                                        }
                                        foreach ($lstClientes as $idx => $campo) {
                                            if ($campo->cli_id == $oUsuarios->cli_id) {
                                                echo "<option value='{$campo->cli_id}' selected>{$campo->cli_nom_empresa}</option>\n";
                                            } else {
                                                echo "<option value='{$campo->cli_id}'>{$campo->cli_nom_empresa}</option>\n";
                                            }
                                        }
                                    }
                                    ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-1">Alias / Nickname:</label>
                <div class="col-sm-20">
                    <input type="text"  id="usr_alias1" name="usr_alias" class="form-control" />
                </div>
            </div><br>
            <div class="form-group" style="float:rigth;">
                <input type="button" id="btnBuscar" class="btn btn-primary" name="btnBuscar"  value="Buscar"/>
                <input type="button" id="btnAgregarNuevo" class="btn btn-success" name="btnAgregarNuevo" value="Agregar nuevo"/>
            </div>
        </center>
        <hr>
        <!-- Modal -->
        <div class="modal fullscreen-modal fade" id="myModal_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Informacion Usuarios</h4>
                    </div>
                    <div style="width:100%;"  class="modal-body" id="divFormulario" >
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-success" id="btnGuardar" value="Guardar">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="divListado" ></div>
        <?php require_once('app/views/default/footer.php'); ?>
    </div>
