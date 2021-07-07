<?php
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "Configuracion.class.php");

$oConfig = new Configuracion();

$sesion = $_SESSION[$oConfig->NombreSesion];

$imgLogon = "";
if (!empty($_SESSION[$oConfig->NombreSesion])){
    $imgLogon = $_SESSION[$oConfig->NombreSesion]->cli_logo;
}
?>
<?php require_once('app/views/default/script.html'); ?>
<!DOCTYPE html PUBLIC >
<html>
<?php require_once('app/views/default/link.html'); ?>
	<head>
		<meta http-equiv="Content-Type" content="text/html;" />
		<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= require_once('app/views/default/head.html'); ?>
		<title>ADMIN</title>
	</head>
<style>body {
		padding-top: 70px;
		/* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
}</style>
<body>
<?php  require_once('app/views/default/menu.php'); ?>
    <div class="container">
				<center><img src="app/views/default/img/bienvenida.png"  style="float:rigth; margin-left:-2px;" width="60%" height="60%"></center>
	  </div>
<?= require_once('app/views/default/footer.php'); ?>

</body>
