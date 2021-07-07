<?php
/**
 * Created by PhpStorm.
 * User: pacorock
 * Date: 23/12/2016
 * Time: 08:46 PM
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/clientes/ClientesPagos.class.php");

$oClientesPagos = new ClientesPagos($_POST);
$lstClientesPagos = $oClientesPagos->Listado();
?>
<script>
    $(document).ready(function(e){
        $("#tblClientes").DataTable();
    });
</script>
<div style="float: left; width: 100%; padding: 5px 0px;">
<table id="tblClientes" class="MiTabla display">
    <thead>
    <tr>
        <th style="width: 350px; text-align: center;">Referencia</th>
        <th style="width: 50px; text-align: center;">Fecha de pago</th>
        <th style="width: 50px; text-align: center;">Importe $(MNX)</th>
        <th style="width: 50px; text-align: center;">Medio</th>
        <th style="width: 50px; text-align: center;">Forma</th>
        <th style="width: 50px; text-align: center;">Sucursal</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th style="width: 350px; text-align: center;">Referencia</th>
        <th style="width: 50px; text-align: center;">Fecha de pago</th>
        <th style="width: 50px; text-align: center;">Importe $(MNX)</th>
        <th style="width: 50px; text-align: center;">Medio</th>
        <th style="width: 50px; text-align: center;">Forma</th>
        <th style="width: 50px; text-align: center;">Sucursal</th>
    </tr>
    </tfoot>
    <tbody>
    <?php
    if (count($lstClientesPagos) > 0) {
        foreach ($lstClientesPagos as $idx => $campo) {
            ?>
            <tr>
                <td><?= $campo->pag_referencia ?></td>
                <td><?= $campo->pag_fecha ?></td>
                <td><?= numfmt_get_error_code($campo->pag_importe, 2) ?></td>
                <td><?= $campo->pag_medio ?></td>
                <td><?= $campo->pag_forma ?></td>
                <td><?= $campo->pag_sucursal ?></td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>
</div>
