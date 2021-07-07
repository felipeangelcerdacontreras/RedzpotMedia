<?php
/**
 * Created by Visual Studio Code.
 * User: ADMINC4
 * Date: 02/07/2019
 * Time: 11:17 PM
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/clientes.class.php");
require_once($_SITE_PATH . "app/model/multimedia.class.php");
require_once($_SITE_PATH . "app/model/niveles.class.php");

$mul_id = addslashes(filter_input(INPUT_POST, "mul_id"));

$oCliente = new Clientes();

$oMulti = new Multimedia();
$oMulti->mul_id = $mul_id;
$oMulti->Informacion();

$lstClientes = $oCliente->Listado();

$oCliente->cli_fecha_vigencia = empty($oCliente->cli_fecha_vigencia) ? date("Y-m-d") : $oCliente->cli_fecha_vigencia;
?>
<script>
$(document).ready(function(e) {
    $("#btnQuitar").button().click(function(e) {
        
        if (confirm("Esta seguro de quitar el contenido multimedia?") == false)
            return;

        var jsonDatos = {
            "mul_id": $("#mul_id").val(),
            "accion": "QUITAR"
        };
        $.ajax({
            data: jsonDatos,
            type: "post",
            url: "app/views/default/modules/spot/multimedia/m.multimedia.procesa.php",
            beforeSend: function() {},
            success: function(data) {
                var str = data;
                var datos0 = str.split("@")[0];
                var datos1 = str.split("@")[1];
                var datos2 = str.split("@")[2];
                var datos3 = str.split("@")[3];
                if (datos3 === undefined) {
                    Alert(datos0, datos1, 'success');
                } else {
                    Alert(datos0, datos1 + "  " + datos3, datos2);
                }
                Editar($("#mul_id").val());
                Listado();
            }
        });
    });

    $("#frmFormulario").ajaxForm({
        beforeSubmit: function(formData, jqForm, options) {},
        success: function(data) {
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
            $("#myModal_1").modal("hide");
            Listado();
        }
    });
    if ($("#mul_ruta").val() == "") {
        $("#btnQuitar").hide();
        $("#videoSrc").css("display", "none");
        $("#foto").css("display", "inline");
    } else {
        $("#btnQuitar").show();
        $("#videoSrc").css("display", "inline");
        $("#foto").css("display", "none");
    }
});
</script>
<div class="container">
    <form id="frmFormulario" name="frmFormulario" action="app/views/default/modules/spot/multimedia/m.multimedia.procesa.php"
        method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-sm-2">Cliente:</label>
            <div class="col-sm-10">
                <select id="cli_id" name="cli_id" class="form-control" <?php
                    if ($_SESSION[$oMulti->NombreSesion]->usr_nivel == 1) {
                        echo "";
                    } else {
                        echo "disabled";
                    }
                    ?>>
                    <option value="" selected>--SElECCIONE--</option>
                    <?php
                        if (count($lstClientes) > 0) {
                            foreach ($lstClientes as $idx => $campo) {
                                if ($campo->cli_id == $oMulti->cli_id) {
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
            <label class="control-label col-sm-2">Archivo multimedia:</label>
            <div class="col-sm-10">
                <input type="file" id="foto" name="foto" value="" multiple="" />
                <?php if ($oMulti->mul_tipo == "MP4") { ?>
                    <video preload="none" autoplay id="videoSrc" name="videoSrc" src="<?= $oMulti->mul_ruta ?>" width="50%"
                    style="height:52%;" border="0" class="form-control" muted></video>
                <?php } else {?>
                    <img id="videoSrc" name="videoSrc" src="<?= $oMulti->mul_ruta ?>" width="64" style="height:40%;" border="0"
                    class="form-control" />
                    <?php }?>
                <br />
                <input type="button" id="btnQuitar" name="btnQuitar" value="Quitar" class="form-control" />
            </div>
        </div>
        <input type="hidden" id="accion" name="accion" value="GUARDAR" />
        <input type="hidden" id="mul_id" name="mul_id" value="<?= $oMulti->mul_id ?>" />
        <input type="hidden" id="mul_ruta" name="mul_ruta" value="<?= $oMulti->mul_ruta ?>" />
    </form>
</div>