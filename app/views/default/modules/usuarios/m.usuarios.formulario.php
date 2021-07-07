<?php
/*
 * Copyright 2016 Geodesarollo Soluciones S. de R.L. de C.V.
 * Correo-E: francisco.torres@geodesa.com.mx
 */
require_once($_SERVER ['DOCUMENT_ROOT'] . "/sicap/app/model/usuarios.class.php");
require_once($_SERVER ['DOCUMENT_ROOT'] . "/sicap/app/model/niveles.class.php");

$oUsuario = new usuarios ();
$oUsuario->usr_id = filter_input(INPUT_POST, "usr_id");
$oUsuario->Informacion();

$oNiveles = new Niveles ($oUsuario->sesion);
$lstNiveles = $oNiveles->Listado();
?>
<script type="text/javascript">
    $(document).ready(function (e) {
        $("#btnQuitarFoto").button().click(function (e) {
            if (confirm("¿Esta seguro que desea quitar la Foto del usuario? Esta acción no se podrá revertir") == false)
                return;

            $.ajax({
                data: "usr_id=" + $("#usr_id").val() + "&accion=QUITAR_FOTO",
                type: "POST",
                url: "app/views/default/modules/usuarios/m.usuarios.procesa.php",
                beforeSend: function () {

                },
                success: function (datos) {
                    MessageBox(datos);
                    $("#divFormulario").dialog("close");
                    Listado();
                }
            });
        });

        $("#frmFormulario").ajaxForm({
            beforeSubmit: function (formData, jqForm, options) {
            },
            success: function (data) {
                MessageBox(data);
                $("#divFormulario").dialog("close");
                Listado();
            }
        });

        // oculto o muestro los botones y elementos para subir el archivo de Foto
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
<form id="frmFormulario" name="frmFormulario" action="app/views/default/modules/usuarios/m.usuarios.procesa.php"
      enctype="multipart/form-data" method="post" target="_self">
    <table class="MiTabla" style="width: 500px;">
        <tr>
            <th style="width: 100px;">Alias:</th>
            <td><input type="text" id="usr_alias" name="usr_alias" value="<?= $oUsuario->usr_alias ?>"
                       style="width: 100px;" maxlength="15"/></td>
        </tr>
        <tr>
            <th>Nombre:</th>
            <td><input type="text" id="usr_nombre" name="usr_nombre" value="<?= $oUsuario->usr_nombre ?>"
                       style="width: 300px;" maxlength="100"/></td>
        </tr>
        <tr>
            <th>Contraseña:</th>
            <td><input type="password" id="usr_pass" name="usr_pass" value="" style="width: 100px;" maxlength="15"/>
            </td>
        </tr>
        <tr>
            <th>Nivel:</th>
            <td><select id="usr_nivel" name="usr_nivel" style="width: 150px;">
                    <?php
                    if (count($lstNiveles) > 0) {
                        foreach ($lstNiveles as $idx => $campo) {
                            if ($campo->nvl_id === $oUsuario->usr_nivel) echo "<option value='{$campo->nvl_id}' selected>{$campo->nvl_nombre}</option>";
                            else echo "<option value='{$campo->nvl_id}'>{$campo->nvl_nombre}</option>";
                        }
                    }
                    ?>
                </select></td>
        </tr>
        <tr>
            <th>Archivo Foto:</th>
            <td>
                <input type="file" id="foto" name="foto" value=""/>
                <img id="imgFoto" name="imgFoto" src="app/views/default/modules/usuarios/<?= $oUsuario->usr_foto ?>"
                     width="64" border="0"/><br/>
                <input type="button" id="btnQuitarFoto" name="btnQuitarFoto" value="Quitar"/>
            </td>
        </tr>
    </table>
    <input type="hidden" id="usr_id" name="usr_id" value="<?= $oUsuario->usr_id ?>"/>
    <input type="hidden" id="accion" name="accion" value=""/>
    <input type="hidden" id="usr_foto" name="usr_foto" value="<?= $oUsuario->usr_foto ?>"/>
</form>