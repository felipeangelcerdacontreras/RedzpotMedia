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
require_once($_SITE_PATH . "app/model/spot.class.php");
require_once($_SITE_PATH . "app/model/niveles.class.php");

$spo_id = addslashes(filter_input(INPUT_POST, "spo_id"));

$oCliente = new Clientes();

$oSpot = new Spot();
$oSpot->spo_id = $spo_id;
$oSpot->getInfo();

$lstClientes = $oCliente->Listado();

$oCliente->cli_fecha_vigencia = empty($oCliente->cli_fecha_vigencia) ? date("Y-m-d") : $oCliente->cli_fecha_vigencia;
?>
<script>
    $(document).ready(function (e) {
        $("#btnQuitarLogo").button().click(function (e) {
            if (confirm("Esta seguro de quitar el logotipo del cliente?") == false)
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
<div class="container">
    <form id="frmFormulario" name="frmFormulario" action="app/views/default/modules/spot/text/m.spot.procesa.php" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-2">Cliente:</label>
                <div class="col-sm-10">
                    <select id="cli_id" name="cli_id" class="form-control" <?php
                    if ($_SESSION[$oSpot->NombreSesion]->usr_nivel == 1) {
                        echo "";
                    } else {
                        echo "disabled";
                    }
                    ?>>
                        <option value="0" selected>--SElECCIONE--</option>
                        <?php
                        if (count($lstClientes) > 0) {
                            foreach ($lstClientes as $idx => $campo) {
                                if ($campo->cli_id == $oSpot->cli_id) {
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
                <label class="control-label col-sm-2">Banner:</label>
                <div class="col-sm-10">
                    <select id="spo_ban" name="spo_ban" class="form-control" >
                        <option value="0">--SELECCIONE--</option>
                        <option value="1"  <?php
                        if ($oSpot->spo_ban == 1) {
                            echo "selected";
                        }
                        ?>>Horizontal</option>
                        <option value="2"  <?php
                        if ($oSpot->spo_ban == 2) {
                            echo "selected";
                        }
                        ?>>Vertical</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Texto de banner:</label>
                <div class="col-sm-10">
                    <textarea id="spo_text" name="spo_text" class="form-control"><?= $oSpot->spo_text ?></textarea>
                </div>
            </div>
            <input type="hidden" id="accion" name="accion" value="GUARDAR"/>
            <input type="hidden" id="spo_id" name="spo_id" value="<?= $oSpot->spo_id ?>"/>
    </form>
</div>