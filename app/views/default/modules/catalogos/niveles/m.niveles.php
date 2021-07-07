<?php
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/niveles.class.php");
require_once($_SITE_PATH . "app/model/clientes.class.php");

$oNiveles = new Niveles();
$oNiveles->ValidaNivelUsuario("niveles_usuarios");

$oClientes = new Clientes();
$oClientes->cli_activo = true;
$oClientes->cli_id = $_SESSION[$oClientes->NombreSesion]->usr_nivel == 1 ? "" : $_SESSION[$oClientes->NombreSesion]->cli_id;
$lstClientes = $oClientes->Listado();
?>
<?php require_once('app/views/default/script.html'); ?>
<script type="text/javascript">
    $(document).ready(function (e) {
        Listado();
        $("#btnGuardar").button().click(function (e) {
            if ($("#cli_id").val() === "0" || $("#nvl_nombre").val() === "") {
                Alert("", "Llene todos los campos porfavor", "warning");
            }
            else {
                $("#frmFormulario").submit();
            }
        });

        $('#btnBuscar').button().click(function (e) {
            Listado();
        });

        $("#btnAgregar").button().click(function (e) {
            Editar("");
        });

        $('#dtBasicExample').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });

    function Listado() {
        var jsonDatos = {
            "cli_id": $("#cbxClientes option:selected").val(),
        };

        $.ajax({
            data: jsonDatos,
            type: "POST",
            url: "app/views/default/modules/catalogos/niveles/m.niveles.listado.php",
            beforeSend: function () {
                $("#divListado").html(ImagenCargando());
            },
            success: function (datos) {
                $("#divListado").html(datos);
            }
        });
    }

    function Editar(nvl_id) {
        $.ajax({
            data: "nvl_id=" + nvl_id,
            type: "POST",
            url: "app/views/default/modules/catalogos/niveles/m.niveles.formulario.php",
            beforeSend: function () {
                $("#divFormulario").html('<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Cargando formulario, espere un momento por favor...</center></div>');
            },
            success: function (datos) {
                $("#divFormulario").html(datos);
            }
        });
        $("#myModal_1").modal({backdrop: ""});
    }

    function Borrar(nvl_id) {
        if (confirm("¿Está seguro de borrar el registro seleccionado?") === false)
            return;

        $.ajax({
            data: "nvl_id=" + nvl_id + "&accion=BORRAR",
            type: "POST",
            url: "app/views/default/modules/catalogos/niveles/m.niveles.procesa.php",
            beforeSend: function () {
                $("#divListado").html('<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Eliminando información, espere un momento por favor...</center></div>');
            },
            success: function (data) {
                var str = data;
              var datos0 = str.split("@")[0];
              var datos1 = str.split("@")[1];
              var datos2 = str.split("@")[2];
              var datos3 = str.split("@")[3];
              if(datos3 === undefined){
                Alert(datos0,datos1,datos2);
              }else{
              Alert(datos0,datos1+"  "+datos3,datos2);
            }
                $("#myModal_1").modal("hide");
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
                    <select id="cbxClientes" class="form-control" name="cbxClientes" >
                        <?php
                        if (count($lstClientes) > 0) {
                            if ($_SESSION[$oNiveles->NombreSesion]->usr_nivel == 1) {
                                echo "<option value=''>-- TODOS --</option>\n";
                            }
                            foreach ($lstClientes as $idx => $campo) {
                                echo "<option value='{$campo->cli_id}' >{$campo->cli_nom_empresa}</option>\n";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-20" style="float:rigth;">
                    <input type="button" id="btnBuscar" class="btn btn-primary" name="btnBuscar" value="Buscar">
                    <input type="button" id="btnAgregar" class="btn btn-success" name="btnAgregar" value="Agregar nivel">
                </div>
            </div>
        </center>
        <hr>
        <!-- Modal -->
        <div class="modal fullscreen-modal fade" id="myModal_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Asignacion de permisos</h4>
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
        <div id="divListado" ></div>
        <?php require_once('app/views/default/footer.php'); ?>
    </div>
