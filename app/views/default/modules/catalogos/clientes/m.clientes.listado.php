<?php
/**
 * Created by PhpStorm.
 * User: pacorock
 * Date: 23/12/2016
 * Time: 08:46 PM
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/clientes.class.php");

$oCliente = new Clientes($_POST);
$lstClientes = $oCliente->Listado();
?>
<script>
    $(document).ready(function (e) {
      $('#dtBasicExample').DataTable();
      $('.dataTables_length').addClass('bs-select');
    });
</script>
<div class="table-responsive">
    <table id="dtBasicExample" class="table table-bordered-curved table-hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th style="text-align: center;">Editar/Eliminar</th>
            <th style="text-align: center;">Descripción</th>
            <th style="text-align: center;">Activo</th>
            <th style="text-align: center;">Logo</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th style="text-align: center;">Editar/Eliminar</th>
            <th style="text-align: center;">Descripción</th>
            <th style="text-align: center;">Activo</th>
            <th style="text-align: center;">Logo</th>
        </tr>
        </tfoot>
        <tbody>
        <?php
        if (count($lstClientes) > 0) {
            foreach ($lstClientes as $idx => $campo) {
                ?>
                <tr>
                    <td style="text-align: center;">
                        <a href="javascript:Editar('<?= $campo->cli_id ?>');"><img
                                    src='app/views/default/img/edit_22x22.png' border="0"/></a>
                        <a href="javascript:Borrar('<?= $campo->cli_id ?>')"><img
                                    src='app/views/default/img/trash_22x22.png' border="0"/></a>
                    </td>
                    <td style="text-align: center;"><?php
                        echo "<strong>{$campo->cli_nom_empresa}</strong><br />
                          RFC: {$campo->cli_rfc}";
                        ?>
                    </td>
                    <td style="text-align: center;">
                        <?php
                        $sImg = "app/views/default/img/no.png";
                        if ($campo->cli_activo == true)
                            $sImg = "app/views/default/img/yes.png";
                        ?>
                        <img src="<?= $sImg ?>"/>
                    </td>
                    <td style="text-align: center;">
                        <?php
                        $sImg = "app/views/default/img/no.png";
                        if (!empty($campo->cli_logo))
                            $sImg = $campo->cli_logo;
                        ?>
                        <img src="<?= $sImg ?>" height="64"/>

                    </td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>
