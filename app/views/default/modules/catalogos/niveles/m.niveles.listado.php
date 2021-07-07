<?php
/**
 * Created by PhpStorm.
 * User: pacorock
 * Date: 04/01/2017
 * Time: 05:58 PM
 */
session_start();
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/niveles.class.php");

$oNiveles = new niveles();
$oNiveles->cli_id = addslashes(filter_input(INPUT_POST, "cli_id"));
$lstNiveles = $oNiveles->Listado();
?>
<script>
    $(document).ready(function (e) {
        
    });
</script>
<div class="table-responsive">
    <table id="dtBasicExample" class="table table-bordered-curved table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="text-align: center">Editar/eliminar</th>
                <th style="text-align: center">Nombre del nivel</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th style="text-align: center">Editar/eliminar</th>
                <th style="text-align: center">Nombre del nivel</th>
            </tr>
        </tfoot>

        <tbody>
            <?php
            if (count($lstNiveles) > 0) {
                foreach ($lstNiveles as $idx => $campo) {

                    // si el nivel del usuario logeado es 2, qe no me muestre su nivel ni el del administrador
                    if ($_SESSION[$oNiveles->NombreSesion]->usr_nivel == 2 && $campo->nvl_id <= 2) {
                        continue;
                    }
                    ?>
                    <tr>
                        <td style="text-align: center;">
                            <a href="javascript:Editar('<?= $campo->nvl_id ?>')"><img
                                    src="app/views/default/img/edit_22x22.png"/></a>
                            <a href="javascript:Borrar('<?= $campo->nvl_id ?>');"><img
                                    src="app/views/default/img/trash_22x22.png"/></a>
                        </td>
                        <td style="text-align: center;"><?= $campo->nvl_nombre ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
