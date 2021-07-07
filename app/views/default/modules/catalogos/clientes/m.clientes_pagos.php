<?php
/**
 * Created by PhpStorm.
 * User: pacorock
 * Date: 24/12/2016
 * Time: 01:48 PM
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/clientes/ClientesPagos.class.php");

$oClientes = new ClientesPagos();
$oClientes->ValidaNivelUsuario();

$pag_fecha1 = date("Y-m-01");
$pag_fecha2 = date("Y-m-d", (mktime(0, 0, 0, date("m") + 1, 1, date("Y")) - 1));

?>
<script>
    $(document).ready(function (e) {
        $("#btnBuscar").button().click(function (e) {
            Listado();
        });

        $("#btnAgregarPagos").button().click(function (e) {
            $("#divAgregarPagos").dialog("open");
        });

        $("#divAgregarPagos").dialog({
            title: "Agregar archivo de pagos",
            autoOpen: false,
            height: 200,
            width: 500,
            modal: true,
            show: {
                //effect:"fade",
                duration: 250
            },
            hide: {
                //effect:"fade",
                duration: 250
            },
            buttons: [
                {
                    text: "Subir información de pagos",
                    icons: {primary: "ui-icon-circle-arrow-n"},
                    click: function (e) {
                    }
                },
                {
                    text: "Cerrar",
                    icons: {primary: "ui-icon-close"},
                    click: function (e) {
                        $("#divAgregarPagos").dialog("close");
                    }
                }
            ]
        });

        $("#frmFormularioDialog").dialog({
            title: "Información del Cliente",
            autoOpen: false,
            height: 570,
            width: 650,
            modal: true,
            show: {
                //effect:"fade",
                duration: 250
            },
            hide: {
                //effect:"fade",
                duration: 250
            },
            buttons: [
                {
                    text: "Guardar",
                    icons: {primary: "ui-icon-disk"},
                    click: function (e) {
                        var jsonDatos = $("#frmCliente").serializeArray();
                        jsonDatos[jsonDatos.length] = {
                            name: "accion", value: "GUARDAR"
                        };

                        $.ajax({
                            data: jsonDatos,
                            type: "post",
                            url: "app/views/default/modules/catalogos/clientes/m.clientes_procesa.php",
                            beforeSend: function () {
                            },
                            success: function (datos) {
                                MessageBox(datos);
                                $("#frmFormularioDialog").dialog("close");
                                Listado();
                            }
                        });
                    }
                },
                {
                    text: "Cerrar",
                    icons: {primary: "ui-icon-close"},
                    click: function (e) {
                        $("#frmFormularioDialog").dialog("close");
                    }
                }
            ]
        });

        $("#pag_fecha1, #pag_fecha2").datepicker({
            showOn: "button",
            changeMonth: true,
            changeYear: true,
            buttonImage: "app/views/default/images/x_office_calendar.png",
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });

        Listado();
    });

    function Listado() {
        var jsonDatos = $("#frmOpciones").serializeArray();
        $.ajax({
            data: jsonDatos,
            type: "post",
            url: "app/views/default/modules/catalogos/clientes/m.clientes_pagos_listado.php",
            beforeSend: function () {
                $("#divListado").html(ImagenCargando());
            },
            success: function (datos) {
                $("#divListado").html(datos);
            }
        });
    }
</script>
<form id="frmOpciones" name="frmOpciones" method="post">
    <table class="MiTabla" style=" margin:0 auto; text-align: center; width: 500px;">
        <tr>
            <th style="width: 200px;">Nombre del cliente:</th>
            <td><input type="text" id="cli_nom_empresa" name="cli_nom_empresa" value="" style="width: 300px;"></td>
        </tr>
        <tr>
            <th>Nombre del representante:</th>
            <td><input type="text" id="cli_nom_representante" name="cli_nom_representante" value=""
                       style="width: 300px;"></td>
        </tr>
        <tr>
            <th>Fechas de consulta:</th>
            <td>
                <input type="text" id="pag_fecha1" name="pag_fecha1" value="<?= $pag_fecha1 ?>" style="width: 80px"
                       readonly/>
                al <input type="text" id="pag_fecha2" name="pag_fecha2" value="<?= $pag_fecha2 ?>" style="width: 80px"
                          readonly/>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;">
                <input type="button" id="btnAgregarPagos" name="btnAgregarPagos" value="Agregar pagos">
                <input type="button" id="btnBuscar" name="btnBuscar" value="Buscar">
            </td>
        </tr>
    </table>
</form>
<div id="divListado"></div>
<div id="divAgregarPagos">
    <table class="MiTabla">
        <tr>
            <th>Archivo Banco:</th>
            <td><input type="file" id="archivoBanco" name="archivoBanco"/></td>
        </tr>
    </table>
</div>
