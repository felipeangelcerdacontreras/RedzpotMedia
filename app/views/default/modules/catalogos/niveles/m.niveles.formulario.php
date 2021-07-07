<?php
/*
 * Copyright 2016 Geodesarollo Soluciones S. de R.L. de C.V.
 * Correo-E: francisco.torres@geodesa.com.mx
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/niveles.class.php");
require_once($_SITE_PATH . "app/model/clientes.class.php");

$oNiveles = new niveles ();
$oNiveles->nvl_id = addslashes(filter_input(INPUT_POST, "nvl_id"));
$oNiveles->Informacion();

$oClientes = new Clientes();
$oClientes->cli_activo = true;
$oClientes->cli_id = $_SESSION[$oClientes->NombreSesion]->usr_nivel == 1 ? "" : $_SESSION[$oClientes->NombreSesion]->cli_id;
$lstClientes = $oClientes->Listado();

$aPermisos = empty($oNiveles->nvl_permisos) ? array() : explode("@", $oNiveles->nvl_permisos);
?>
<script type="text/javascript">
    $(document).ready(function (e) {
        $("#frmFormulario").ajaxForm({
            beforeSubmit: function (formData, jqForm, options) {
                $("#divFormulario").html('<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Guardando Informacion, espere un momento por favor...</center></div>');
            },
            success: function (data) {
              var str = data;
              var datos0 = str.split("@")[0];
              var datos1 = str.split("@")[1];
              var datos2 = str.split("@")[2];
              var datos3 = str.split("@")[3];
              if(datos3 === undefined){
                Alert(datos0,datos1,datos2);
              }else{
              Alert(datos0,datos1+"  "+datos3,datos2);
            }
                $("#myModal_1").modal("hide");
                Listado();
            }
        });
    });
</script>
<form id="frmFormulario" name="frmFormulario" method="post" target="_self"
      action="app/views/default/modules/catalogos/niveles/m.niveles.procesa.php" class="form-horizontal">
          <div class="form-group">
            <label class="control-label col-sm-2">Cliente:</label>
             <div class="col-sm-10">
               <select id="cli_id" name="cli_id" class="form-control">
                 <option value="0">--SELECCIONE--</option>
                            <?php
                            if (count($lstClientes) > 0) {
                                foreach ($lstClientes as $idx => $campo) {
                                    if ($campo->cli_id == $oNiveles->cli_id)
                                        echo "<option value='{$campo->cli_id}' selected>{$campo->cli_nom_empresa}</option>\n";
                                    else
                                        echo "<option value='{$campo->cli_id}'>{$campo->cli_nom_empresa}</option>\n";
                                }
                            }
                            ?>
                        </select>
                      </div>
                		 </div>
                     <div class="form-group">
                       <label class="control-label col-sm-2">Nombre del nivel:</label>
                        <div class="col-sm-10">
                          <input type="text" id="nvl_nombre" name="nvl_nombre" value="<?= $oNiveles->nvl_nombre ?>"maxlength="25" class="form-control"/>
                        </div>
                       </div>
                       <div >
                         <center>
                       <h1>PERMISOS</h1>
                     </center>
                     </div>
          <div class="table-responsive">
            <table id="dtBasicExample" class="table table-bordered-curved table-hover" cellspacing="0" width="100%">
                <tr>
                    <?php
                    if ($_SESSION[$oNiveles->NombreSesion]->usr_nivel == 1) {
                        // Permisos para Administrador del Sistema
                        ?>
                        <td style="vertical-align: top;">
                            <strong>Catálogos</strong><br/>
                            <input type="checkbox" name="nvl_permisos[]"
                                   value="clientes" <?php if ($oNiveles->ExistePermiso("clientes", $aPermisos) === true) echo "checked" ?>>
                            Clientes <br/>
                            <input type="checkbox" name="nvl_permisos[]"
                                   value="niveles_usuarios" <?php if ($oNiveles->ExistePermiso("niveles_usuarios", $aPermisos) === true) echo "checked" ?>>
                            Niveles de usuarios <br/>
                            <input type="checkbox" name="nvl_permisos[]"
                                   value="poblaciones" <?php if ($oNiveles->ExistePermiso("poblaciones", $aPermisos) === true) echo "checked" ?>>
                            Sugerencias<br/>
                            <input type="checkbox" name="nvl_permisos[]"
                                   value="usuarios" <?php if ($oNiveles->ExistePermiso("usuarios", $aPermisos) === true) echo "checked" ?>>
                            Usuarios<br/>
                        </td>
                        <?php
                    } else if ($_SESSION[$oNiveles->NombreSesion]->usr_nivel == 2) {
                        ?>
                        <td style="vertical-align: top;">
                            <strong>Catálogos</strong><br/>
                            <input type="checkbox" name="nvl_permisos[]"
                                   value="niveles_usuarios" <?php if ($oNiveles->ExistePermiso("niveles_usuarios", $aPermisos) === true) echo "checked" ?>>
                            Niveles de usuarios <br/>
                            <input type="checkbox" name="nvl_permisos[]"
                                   value="usuarios" <?php if ($oNiveles->ExistePermiso("usuarios", $aPermisos) === true) echo "checked" ?>>
                            Usuarios<br/>
                        </td>                    <?php
                    }
                    ?>
                    <td style="vertical-align: top;">
                        <strong>Otros</strong><br/>
                        <input type="checkbox" name="nvl_permisos[]"
                               value="buzon_sugerencias" <?php if ($oNiveles->ExistePermiso("buzon_sugerencias", $aPermisos) === true) echo "checked" ?>>
                        Buzón de sugerencias<br/>
                    </td>
                    <td style="vertical-align: top;">
                        <strong>Spots</strong><br/>
                        <input type="checkbox" name="nvl_permisos[]"
                               value="spot_multimedia" <?php if ($oNiveles->ExistePermiso("spot_multimedia", $aPermisos) === true) echo "checked" ?>>
                        Spot multimedia<br/>
                        <input type="checkbox" name="nvl_permisos[]"
                               value="spot" <?php if ($oNiveles->ExistePermiso("spot", $aPermisos) === true) echo "checked" ?>>
                        Spot texto<br/>
                        <input type="checkbox" name="nvl_permisos[]"
                               value="reproductor" <?php if ($oNiveles->ExistePermiso("reproductor", $aPermisos) === true) echo "checked" ?>>
                        Reproductor<br/>
                    </td>
                </tr>
            </table>
          </div>
    <input type="hidden" id="accion" name="accion" value="GUARDAR"/>
    <input type="hidden" id="nvl_id" name="nvl_id" value="<?= $oNiveles->nvl_id ?>"/>
</form>
