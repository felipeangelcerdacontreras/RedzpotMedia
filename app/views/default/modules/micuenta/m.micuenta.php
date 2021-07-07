<?php
/*
 * Copyright 2016 Geodesarollo Soluciones S. de R.L. de C.V.
 * Correo-E: francisco.torres@geodesa.com.mx
 */
//session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/usuariosCuenta.class.php");
require_once($_SITE_PATH . "app/model/clientes.class.php");
require_once($_SITE_PATH . "app/model/niveles.class.php");

$oClientes = new Clientes();
$oClientes->cli_activo = 1;

if ($_SESSION[$oClientes->NombreSesion]->usr_nivel == 2) {
    $oClientes->cli_id = $_SESSION[$oClientes->NombreSesion]->cli_id;
}

$lstClientes = $oClientes->Listado();

$oUsuario = new usuarioscuenta();
$oUsuario->usr_id = $_SESSION[$oClientes->NombreSesion]->usr_id;

$oUsuario->Informacion();

$oNiveles = new niveles ();
$lstNiveles = $oNiveles->Listado();
?>
<?php require_once('app/views/default/script.html'); ?>
<script type="text/javascript">
    $(document).ready(function (e) {
        $("#btnQuitarFoto").button().click(function (e) {
            if (confirm("¿Esta seguro que desea quitar la foto del usuario? Esta acción no se podrá revertir") === false)
                return;

            $.ajax({
                data: "usr_id=" + $("#usr_id").val() + "&accion=QUITAR_FOTO",
                type: "POST",
                url: "app/views/default/modules/micuenta/m.micuenta.procesa.php",
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
                    setTimeout(function () {
                        location.reload(); //actualizas el div
                    }, 1000);
                }
            });
        });

        $("#cbxPass").change(function (e) {

            if ($("#cbxPass").is(":checked")) {
                $("#usr_pass").prop("disabled", false);
            }
            else
                $("#usr_pass").prop("disabled", true);
        });
        $("#btnGuardar").click(function (e) {
            if ($("#usr_alias").val() == "" || $("#usr_nombre").val() == "" || $("#usr_nivel").val() == "0" || $("#usr_correoe").val() == "") {
                Alert("", "Llene todos los campos porfavor", "warning");
            }
            else {
                $("#frmFormulario").submit();
            }
        });
        $("#frmFormulario").ajaxForm({
            beforeSubmit: function (formData, jqForm, options) {
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
                setTimeout(function () {
                    location.reload(); //actualizas el div
                }, 1000);
            }
        });

        if ($("#usr_foto").val() == "") {
            $("#btnQuitarFoto").hide();
            $("#imgFoto").css("display", "none");
            $("#foto").css("display", "inline");
        } else {
            $("#btnQuitarFoto").show();
            $("#imgFoto").css("display", "inline");
            $("#foto").css("display", "none");
        }
    });
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
        <title>Mi Cuenta</title>
    </head>
    <style>body {
            padding-top: 70px;
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }</style>
        <?php require_once('app/views/default/menu.php'); ?>
    <body>
        <div class="container" id="form">
            <form id="frmFormulario" name="frmFormulario" action="app/views/default/modules/micuenta/m.micuenta.procesa.php" enctype="multipart/form-data" method="post" target="_self" class="form-horizontal">
                <div style="margin:auto;">
                    <center>
                        <div class="form-group" <?php if ($_SESSION[$oClientes->NombreSesion]->usr_nivel == 1) {echo "";}else{echo "hidden";} ?> >
                            <label class="control-label col-sm-2">Cliente:</label>
                            <div class="col-sm-10">
                                <select id="cli_id" name="cli_id" class="form-control" <?php
                                if ($_SESSION[$oClientes->NombreSesion]->usr_nivel == 1) {
                                    echo "";
                                } else {
                                    echo "disabled";
                                }
                                ?>>
                                    <option value="0" selected>--SElECCIONE--</option>
                                    <?php
                                    if (count($lstClientes) > 0) {
                                        foreach ($lstClientes as $idx => $campo) {
                                            if ($campo->cli_id == $oUsuario->cli_id) {
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
                            <label class="control-label col-sm-2">Alias:</label>
                            <div class="col-sm-10">
                                <input type="text" id="usr_alias" required name="usr_alias" value="<?= $oUsuario->usr_alias ?>" maxlength="15" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" id="usr_nombre" required name="usr_nombre" value="<?= $oUsuario->usr_nombre ?>" maxlength="100" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Contraseña:</label>
                            <div class="col-sm-10">
                                <input type="password" id="usr_pass" name="usr_pass" value="" maxlength="45" disabled class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Modificar Contraseña </label>
                            <div class="col-sm-10">
                                <input type="checkbox" id="cbxPass"  class="form-control" name="cbxPass"/>
                            </div>
                        </div>
                        <div class="form-group" <?php if ($_SESSION[$oClientes->NombreSesion]->usr_nivel == 1) {echo "";}else{echo "hidden";} ?> >
                            <label class="control-label col-sm-2">Nivel:</label>
                            <div class="col-sm-10">
                                <select id="usr_nivel" name="usr_nivel" class="form-control" <?php
                                if ($_SESSION[$oClientes->NombreSesion]->usr_nivel == 1) {
                                    echo "";
                                } else {
                                    echo "disabled";
                                }
                                ?>>
                                    <option value="0" selected>--SElECCIONE--</option>
                                    <?php
                                    if (count($lstNiveles) > 0) {
                                        foreach ($lstNiveles as $idx => $campo) {

                                            if ($campo->nvl_id == 1 && $_SESSION[$oClientes->NombreSesion]->usr_nivel != 1)
                                                continue;

                                            if ($campo->nvl_id === $oUsuario->usr_nivel)
                                                echo "<option value='{$campo->nvl_id}' selected>{$campo->nvl_nombre}</option>";
                                            else
                                                echo "<option value='{$campo->nvl_id}'>{$campo->nvl_nombre}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Archivo de foto:</label>
                            <div class="col-sm-10">
                                <input type="file" id="foto" name="foto" value=""/>
                                <img id="imgFoto" name="imgFoto" src="<?= $oUsuario->usr_foto ?>" width="64" style="height:40%;" border="0" class="form-control"/><br/>
                                <input type="button" id="btnQuitarFoto" name="btnQuitarFoto" value="Quitar" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Correo-E:</label>
                            <div class="col-sm-10">
                                <input type="text" id="usr_correoe" required name="usr_correoe" value="<?= $oUsuario->usr_correoe ?>" maxlength="100" placeholder="correo@dominio.com" class="form-control"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-success" id="btnGuardar" value="Guardar">
                        </div>
                        <input type="hidden" id="usr_id" name="usr_id" value="<?= $oUsuario->usr_id ?>"/>
                        <input type="hidden" id="accion" name="accion" value="GUARDAR"/>
                        <input type="hidden" id="usr_foto" name="usr_foto" value="<?= $oUsuario->usr_foto ?>"/>
                    </center>
                </div>
            </form>
            <iframe name="pp" style="position:absolute; top:-1500px;"></iframe>
            <?php require_once('app/views/default/footer.php'); ?>
        </div>
    </body>
