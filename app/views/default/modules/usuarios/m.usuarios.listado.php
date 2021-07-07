<?php
/*
 * Copyright 2016 Geodesarollo Soluciones S. de R.L. de C.V.
 * Correo-E: francisco.torres@geodesa.com.mx
 */
require_once($_SERVER['DOCUMENT_ROOT'] . "/geodesk/app/model/usuarios.class.php");

$oUsuario = new usuarios();
$oUsuario->usr_nombre = filter_input(INPUT_POST, "usr_nombre");
$lstUsuarios = $oUsuario->Listado();

?>
<script type="text/javascript">
    $(document).ready(function (e) {
        $("#tblLista").DataTable();

        $("#btnAgregar").button().click(function (e) {
            Editar("");
        });

        $("#divFormulario").dialog({
            title: "Información del Usuario",
            autoOpen: false,
            height: 350,
            width: 550,
            modal: true,
            show: {
                //effect:"fade",
                duration: 250
            },
            hide: {
                //effect:"fade",
                duration: 250
            },
            buttons: [{
                text: "Guardar",
                icons: {
                    primary: "ui-icon-disk"
                },
                click: function (e) {
                    $("#accion").val("GUARDAR");
                    $("#frmFormulario").submit();
                    $("#accion").val("");
                }
            }, {
                text: "Cerrar",
                icons: {
                    primary: "ui-icon-close"
                },
                click: function (e) {
                    $("#divFormulario").dialog('close');
                }
            }]
        });


    });

    function Editar(usr_id) {
        $.ajax({
            data: "usr_id=" + usr_id,
            type: "POST",
            url: "app/views/default/modules/usuarios/m.usuarios.formulario.php",
            beforeSend: function () {
                $("#divFormulario").html('<center><img src="app/views/default/images/loading.gif" border="0"/><br />Leyendo información de la Base de Datos, espere un momento por favor...</center>');
            },
            success: function (datos) {
                $("#divFormulario").html(datos);
            }
        });

        $("#divFormulario").dialog('open');
    }

    function Borrar(usr_id) {
        if (confirm("¿Estas seguro de borrar el registro seleccionado?") == false)
            return;

        $.ajax({
            data: "usr_id=" + usr_id + "&accion=BORRAR",
            type: "POST",
            url: "app/views/default/modules/usuarios/m.usuarios.procesa.php",
            beforeSend: function () {
                $("#divListado").html('<center><img src="app/views/default/images/loading.gif" border="0"/><br />Leyendo información de la Base de Datos, espere un momento por favor...</center>');
            },
            success: function (datos) {
                MessageBox(datos);
                Listado();
            }
        });
    }

</script>
<div style="text-align: center; float: left; width: 100%;">
    <table id="tblLista" style="margin: 0px auto; text-align: left;" class="display MiTabla">
        <thead>
        <tr>
            <th style="width: 70px; text-align: center;"></th>
            <th style="width: 100px; text-align: left;">Alias</th>
            <th style="width: 350px; text-align: left;">Nombre</th>
            <th style="width: 100px; text-align: center;">Nivel</th>
        </tr>
        </thead>

        <tbody>
        <?php
        if (count($lstUsuarios) > 0) {
            foreach ($lstUsuarios as $idx => $campo) {
                ?>
                <tr>
                    <td style="text-align: center;"><a href="javascript:Editar('<?= $campo->usr_id ?>')"><img
                                src="app/views/default/images/edit_22x22.png" border='0' width="22"/></a><a
                            href="javascript:Borrar('<?= $campo->usr_id ?>')"><img
                                src="app/views/default/images/trash_22x22.png" border='0' width="22"/></a></td>
                    <td style="text-align: center;"><?php
                        if (!empty($campo->usr_foto)) {
                            echo "<img src='app/views/default/modules/usuarios/{$campo->usr_foto}' width=32 border=0 />";
                            echo "<br />";
                        } else {
                            echo "<img src='app/views/default/images/profile.png' width=32 border=0 />";
                            echo "<br />";
                        }
                        echo "<strong>{$campo->usr_alias}</strong>";
                        ?></td>
                    <td style="text-align: left;"><?= $campo->usr_nombre ?></td>
                    <td style="text-align: center;"><?= $campo->nvl_nombre ?></td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
    <div>
        <input type="button" id="btnAgregar" name="btnAgregar" value="Agregar"/>
    </div>
</div>
<div id="divFormulario"></div>