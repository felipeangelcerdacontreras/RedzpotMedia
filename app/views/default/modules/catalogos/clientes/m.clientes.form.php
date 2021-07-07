<?php
/**
 * Created by PhpStorm.
 * User: pacorock
 * Date: 23/12/2016
 * Time: 09:40 PM
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/clientes.class.php");
require_once($_SITE_PATH . "app/model/niveles.class.php");

$cli_id = addslashes(filter_input(INPUT_POST, "cli_id"));

$oCliente = new Clientes();
$oCliente->cli_id = $cli_id;
$oCliente->getInfo();

$oNiveles = new niveles();
$lstNiveles = $oNiveles->Listado();

$oCliente->cli_fecha_vigencia = empty($oCliente->cli_fecha_vigencia) ? date("Y-m-d") : $oCliente->cli_fecha_vigencia;
?>
<script>
    $(document).ready(function (e) {
        if ($("#cli_logo").val() == "") {
            $("#btnQuitarFoto").hide();
            $("#cli_log").css("display", "none");
            $("#foto").css("display", "inline");
        } else {
            $("#btnQuitarFoto").show();
            $("#cli_log").css("display", "inline");
            $("#foto").css("display", "none");
        }
        
        $("#btnQuitarFoto").button().click(function (e) {
            if (confirm("Esta seguro de quitar la foto?") === false)
                return;

            var jsonDatos = {
                "cli_id": $("#cli_id").val(),
                "accion": "QUITAR_LOGO"
            };
            $.ajax({
                data: jsonDatos,
                type: "post",
                url: "app/views/default/modules/catalogos/clientes/m.clientes.procesa.php",
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
                    Editar($("#cli_id").val());
                    Listado();
                }
            });
        });

        $("#frmFormulario").ajaxForm({
            beforeSubmit: function (formData, jqForm, options) {
            },
            success: function (data) {
                Listado();
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
            }
        });
    });
</script>

<form id="frmFormulario" name="frmFormulario" action="app/views/default/modules/catalogos/clientes/m.clientes.procesa.php"
      method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="form-group">
        <label class="control-label col-sm-2">Nombre del cliente:</label>
        <div class="col-sm-10">
            <input type="text" id="cli_nom_empresa" name="cli_nom_empresa" value="<?= $oCliente->cli_nom_empresa ?>" class="form-control"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">RFC:</label>
        <div class="col-sm-10">
            <input type="text" id="cli_rfc" name="cli_rfc" maxlength="13" value="<?= $oCliente->cli_rfc ?>" placeholder="ABCD123456789" class="form-control"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Nom. Representante legal:</label>
        <div class="col-sm-10">
            <input type="text" id="cli_nom_representante" name="cli_nom_representante" maxlength="100" value="<?= $oCliente->cli_nom_representante ?>" placeholder="" class="form-control"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Dirección:</label>
        <div class="col-sm-10">
            <textarea id="cli_direccion" name="cli_direccion" class="form-control"><?= ($oCliente->cli_direccion) ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Correo-E (Cliente):</label>
        <div class="col-sm-10">
            <input type="text" id="cli_correo_empresa" name="cli_correo_empresa" maxlength="80" value="<?= $oCliente->cli_correo_empresa ?>" placeholder="micorreo@dominio.com" class="form-control"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Teléfono (Cliente):</label>
        <div class="col-sm-10">
            <input type="text" id="cli_tel_empresa" name="cli_tel_empresa" maxlength="11" value="<?= $oCliente->cli_tel_empresa ?>" placeholder="123-1234567" class="form-control"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Teléfono (Rep. Legal):</label>
        <div class="col-sm-10">
            <input type="text" id="cli_tel_representante" name="cli_tel_representante" maxlength="11" value="<?= $oCliente->cli_tel_representante ?>" placeholder="123-1234567" class="form-control"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Estatus:</label>
        <div class="col-sm-10">
            <select id="cli_activo" name="cli_activo" class="form-control">
                <option value="1" <?php if ($oCliente->cli_activo == true) echo "selected"; ?>>ACTIVO</option>
                <option value="0" <?php if ($oCliente->cli_activo == false) echo "selected"; ?>>INACTIVO</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Fecha de vigencia:</label>
        <div class="col-sm-10">
            <input type="date" id="cli_fecha_vigencia" name="cli_fecha_vigencia" class="form-control" maxlength="10" value="<?= $oCliente->cli_fecha_vigencia ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Archivo de foto:</label>
        <div class="col-sm-10">
            <input type="file" id="foto" name="foto" value=""/>
            <img id="cli_log" name="cli_log" src="<?= $oCliente->cli_logo ?>" width="64" style="height:40%;" border="0" class="form-control"/><br/>
            <input type="button" id="btnQuitarFoto" name="btnQuitarFoto" value="Quitar" class="form-control"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Slogan del cliente:</label>
        <div class="col-sm-10">
            <textarea id="cli_slogan" name="cli_slogan" class="form-control"><?= $oCliente->cli_slogan ?></textarea>
        </div>
    </div>
    <input type="hidden" id="accion" name="accion" value="GUARDAR"/>
    <input type="hidden" id="cli_id" name="cli_id" value="<?= $oCliente->cli_id ?>"/>
    <input type="hidden" id="cli_logo" name="cli_logo" value="<?= $oCliente->cli_logo ?>"/>
</form>
