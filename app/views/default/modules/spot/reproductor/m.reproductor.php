<?php
/**
 * Created by Visual Studio Code.
 * User: ADMINC4
 * Date: 02/07/2019
 * Time: 11:17 PM
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/lista.class.php");
require_once($_SITE_PATH . "app/model/clientes.class.php");
require_once($_SITE_PATH . "app/model/usuarios.class.php");

/*$oLis = new Lista();

$oClientes = new Clientes();
$oClientes->cli_activo = 1;

if ($_SESSION[$oClientes->NombreSesion]->usr_nivel > 2) {
    $oClientes->cli_id = $_SESSION[$oClientes->NombreSesion]->cli_id;
}

$lstClientes = $oClientes->Listado();

$oUsuario = new usuarios();
$oUsuario->usr_id = $_SESSION[$oClientes->NombreSesion]->usr_id;

$oUsuario->Informacion();*/

$lista=file_get_contents('spots/lista/1/1.txt');
$texto=file_get_contents('spots/texto/1/1.txt');

?>
<html>
<head>
    <?php require_once('app/views/default/link.html'); ?>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
	body
	{
	  margin: 0;
		overflow: hidden;
	}
	.video-container
	{
		background-color: #000;
		width: 100%;
	    height: 93%;
		margin-top: -5;

	}
	video {
		width: 100%;
	 height: 100%;
	}
	#uno {
	position: absolute;
    /* background-color: red; */
    top: 0px;
    left: 0px;
    margin: 0px auto;
    width: 100%;
    height: 396%;
 }
	#banner {
    top: 71px;
	/*background-color: #000 ;*/
    height: 5%;
    /*margin-top: 0px;
    margin-bottom: 0px;*/
    width: 100%;
    padding: 0px;
	position:relative;
  }
	.texto-encima{
    padding-top: 1px;
    position: absolute;
    left: 10px;
	font-size: 2vw;
   }
	</style>
    <?php require_once('app/views/default/script.html'); ?>

    <!-- Insert to your webpage before the </head> -->
    <script src="app/views/default/javascript/sliderengine/jquery.js"></script>
    <script src="app/views/default/javascript/sliderengine/amazingslider.js"></script>
    <link rel="stylesheet" type="text/css" href="app/views/default/javascript/sliderengine/amazingslider-1.css">
    <script src="app/views/default/javascript/sliderengine/initslider-1.js"></script>
    <!-- End of head section HTML codes -->
<body>
    <!--quitar click derecho oncontextmenu="return false" onmousedown="return false" onmouseup="return false" onselect="return false" onselectstart="return false" onmouseover="return false" onmouseout="return false" -->
    <div class="contenedor">
        <div class="video-container">
            <!--<label style="color:#FFF;" id="info" hidden></label>
			<input input type="text" id="text" hidden /> Insert to your webpage where you want to display the slider -->
            <div id="amazingslider-wrapper-1"
                style="display:block;position:relative;max-width:100%;height:120%;margin-top:-62px;">
                <div id="amazingslider-1" style="display:block;position:relative;margin-top:-10px;">
                    <ul class="amazingslider-slides" style="display:none;">
                        <?php echo $lista;?>
                    </ul>
                </div>
            </div>
        </div>
        <div id="banner" >
        <marquee  width="92%" height="100%" scrollamount="5" scrolldelay="100" scrollamount="5" direction="left" loop="infinite" class="texto-encima" >
                <label style="color: #fff" id="label"><?php echo $texto; ?></label>
            </marquee>
            <img src="app\views\default\modules\spot\reproductor\barra.png" width="100%" height="97.5%">
            <div id="uno" >
                <img src="app\views\default\modules\spot\reproductor\logo.png" width="13%" height="25%">
            </div>
        </div>
        <!-- End of body section HTML codes -->
    </div>
</body>
