<?php
/*
 * Copyright 2016 Geodesarollo Soluciones S. de R.L. de C.V.
 * Correo-E: francisco.torres@geodesa.com.mx
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/usuarios.class.php");

$oUsuario = new Usuarios();
$oUsuario->usr_alias = addslashes(filter_input(INPUT_POST, "usr_alias"));
$oUsuario->cli_id = addslashes(filter_input(INPUT_POST, "cli_id"));
$lstUsuarios = $oUsuario->Listado();
?>
<script type="text/javascript">
    $(document).ready(function (e) {
        //$("#tblLista").DataTable();

        $("#btnAgregar").button().click(function (e) {
            Editar("");
        });
        $('#dtBasicExample').DataTable();
        $('.dataTables_length').addClass('bs-select');
});

</script>
<div class="table-responsive">
  <table id="dtBasicExample" class="table table-bordered-curved table-hover" cellspacing="0" width="100%">
    <thead class="table thead-dark" >
        <tr>
            <th style="text-align: center">Editar/Eliminar</th>
            <th  style="text-align: center">Alias</th>
            <th  style="text-align: center">Nombre</th>
            <th  style="text-align: center">Nivel</th>
            <th  style="text-align: center">Correo-E</th>
            <th  style="text-align: center">Cliente</th>
        </tr>
        </thead>

        <tbody>
        <?php
        if (count($lstUsuarios) > 0) {
            foreach ($lstUsuarios as $idx => $campo) {
                ?>
                <tr>
                    <td style="text-align: center;"><a href="javascript:Editar('<?= $campo->usr_id ?>')"><img
                                    src="app/views/default/img/edit_22x22.png" border='0' width="22"/></a><a
                                href="javascript:Borrar('<?= $campo->usr_id ?>')"><img
                                    src="app/views/default/img/trash_22x22.png" border='0' width="22"/></a></td>
                    <td style="text-align: center;"><?php
                        if (!empty($campo->usr_foto)) {
                            echo "<img src='{$campo->usr_foto}' width=32 border=0 />";
                            echo "<br />";
                        } else {
                            echo "<img src='app/views/default/img/profile.png' width=32 border=0 />";
                            echo "<br />";
                        }
                        echo "<strong>{$campo->usr_alias}</strong>";
                        ?></td>
                    <td style="text-align: center;"><?= $campo->usr_nombre ?></td>
                    <td style="text-align: center;"><?= $campo->nvl_nombre ?></td>
                    <td style="text-align: center;"><?= $campo->usr_correoe ?></td>
                    <td style="text-align: center;"><?php
                        echo "<strong>" . $campo->cli_nom_empresa . "</strong><br />";
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
        <tfoot>
          <tr>
              <th style="text-align: center">Editar/Eliminar</th>
              <th  style="text-align: center">Alias</th>
              <th  style="text-align: center">Nombre</th>
              <th  style="text-align: center">Nivel</th>
              <th  style="text-align: center">Correo-E</th>
              <th  style="text-align: center">Cliente</th>
          </tr>
        </tfoot>
    </table>
</div>
