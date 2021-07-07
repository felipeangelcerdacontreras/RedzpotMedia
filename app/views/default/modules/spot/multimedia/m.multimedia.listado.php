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

$cli_id = addslashes(filter_input(INPUT_POST, "cli_id"));
$cli_activo = addslashes(filter_input(INPUT_POST, "cli_activo"));


$oMulti = new Multimedia($_POST);
$oMulti->cli_id = $cli_id;
$oMulti->cli_activo = $cli_activo;
$lstSpots = $oMulti->Listado();
?>
<style>
td:hover {
    cursor: move;
}
</style>
<script>
$(document).ready(function(e) {

    $("#btnLista").button().click(function(e) {
        $("#frmFormulario1").submit();
    });

    $("#frmFormulario1").ajaxForm({
        beforeSubmit: function(formData, jqForm, options) {},
        success: function(data) {
             var str = data;
             var texto = "";
             var texto = str.split("@")[0];
             var id = str.split("@")[1];
             
             var jsonDatos = {
                "id": id,
                "texto": texto,
                "accion": "TXT"
            };
            
             $.ajax({
            data: jsonDatos,
            type: "post",
            url: "app/views/default/modules/spot/multimedia/m.multimedia.procesa.php",
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
                Listado();
                }
            });
        }
        
    });

    $("#dataTable").DataTable( {
        pageLength : 50,
        lengthMenu: [[100, -1], [100, 'Todos']]
    });

    $('.dataTables_length').addClass('bs-select');

    var fixHelperModified = function(e, tr) {
            var $originals = tr.children();
            var $helper = tr.clone();
            $helper.children().each(function(index) {
                $(this).width($originals.eq(index).width())
            });
            return $helper;
        },
        updateIndex = function(e, ui) {
            $('td.index', ui.item.parent()).each(function(i) {
                $(this).html(i + 1);
            });
            $('input[type=text]', ui.item.parent()).each(function(i) {
                $(this).val(i + 1);
            });
        };

        $("#dataTable tbody").sortable({
        helper: fixHelperModified,
        stop: updateIndex
    }).disableSelection();

    $("tbody").sortable({
        distance: 5,
        delay: 100,
        opacity: 0.6,
        cursor: 'move',
        update: function() {}
    });
});

</script>
<div class="table-responsive">
    <form id="frmFormulario1" name="frmFormulario1"
        action="app/views/default/modules/spot/multimedia/m.multimedia.procesa.php" method="post"
        class="form-horizontal">
        <table id="dataTable" class="table table-bordered-curved table-hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th style="text-align: center;">Editar/Eliminar</th>
                    <th style="text-align: center;">Multimedia</th>
                    <th style="text-align: center;">Tipo</th>
                    <th style="text-align: center;" hidden >orden</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th style="text-align: center;">Editar/Eliminar</th>
                    <th style="text-align: center;">Multimedia</th>
                    <th style="text-align: center;">Tipo</th>
                    <th style="text-align: center;" hidden >orden</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
        if (count($lstSpots) > 0) {
            $cont = 1;
            foreach ($lstSpots as $idx => $campo) {
                ?>
                <tr id="<?=$cont?>">
                    <td style="text-align: center;">
                        <input type="number" hidden  name="id_<?=$cont?>" id="id_<?=$cont?>" value="<?=  $campo->mul_id  ?>">
                        <a href="javascript:Editar('<?= $campo->mul_id ?>');"><img
                                src='app/views/default/img/edit_22x22.png' border="0" /></a>
                        <a href="javascript:Borrar('<?= $campo->mul_id ?>')"><img
                                src='app/views/default/img/trash_22x22.png' border="0" /></a>
                    </td>
                    <td style="text-align: center;"><?php if ($campo->mul_tipo == 'MP4') {
                                                            echo "<video src='{$campo->mul_ruta}' muted width=50 border=0  ></video>";
                                                        }
                                                        if ($campo->mul_tipo != 'MP4') {
                                                            echo "<img width=50 border=0 src='{$campo->mul_ruta}'/>";
                                                        };
                                                        ?>
                    </td>

                    <td style="text-align: center;"><?= $campo->mul_tipo ?></td>
                    <td class="indexInput" hidden>
                        <input type="text" hidden name="orden_<?=$cont?>"  id="orden_<?= $cont ?>" value="<?= $cont ?>">
                        <input type="hidden" name="cli_id_<?=$cont?>"  id="cli_id_<?=$cont?>" value="<?= $campo->cli_id ?>">
                    </td>
                </tr>
                <?php
             $cont++;
            } 
            echo "<input type='number'  name='final' id='final' value='$cont'>";
        }
        ?>
            </tbody>
        </table>
        <div class="modal-footer">
            <input type="hidden" id="accion" name="accion" value="LISTA" />
            <input type="button" class="btn btn-success" id="btnLista" value="Guardar lista">
        </div>
    </form>

</div>