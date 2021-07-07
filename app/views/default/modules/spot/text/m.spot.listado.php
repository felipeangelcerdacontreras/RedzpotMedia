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
require_once($_SITE_PATH . "app/model/spot.class.php");

$oSpot = new Spot($_POST);
$lstSpots = $oSpot->Listado();
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
            <th style="text-align: center;">Cliente</th>
            <th style="text-align: center;">Activo</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th style="text-align: center;">Editar/Eliminar</th>
            <th style="text-align: center;">Cliente</th>
            <th style="text-align: center;">Activo</th>
        </tr>
        </tfoot>
        <tbody>
        <?php
        if (count($lstSpots) > 0) {
            foreach ($lstSpots as $idx => $campo) {
                ?>
                <tr>
                    <td style="text-align: center;">
                        <a href="javascript:Editar('<?= $campo->spo_id ?>');"><img
                                    src='app/views/default/img/edit_22x22.png' border="0"/></a>
                        <a href="javascript:Borrar('<?= $campo->spo_id ?>')"><img
                                    src='app/views/default/img/trash_22x22.png' border="0"/></a>
                    </td>
                    <td style="text-align: center;"><?php
                        echo "<strong>{$campo->cli_nom_empresa}</strong><br/>";
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
                   
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>
