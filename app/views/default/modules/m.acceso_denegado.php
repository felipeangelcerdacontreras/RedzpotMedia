<?php
/**
 * Created by PhpStorm.
 * User: pacorock
 * Date: 24/12/2016
 * Time: 02:03 PM
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
$_SITE_HTTP = "http://" . $_SERVER["SERVER_NAME"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
//foreach ($_SERVER as $idx => $campo) echo "$idx => $campo<br/>";

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
      <?php require_once('app/views/default/head.html'); ?>
  		<title>ACCESO DENEGADO</title>
<body>
<?php require_once('app/views/default/menu.php'); ?>
  <nav class="navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="collapsed navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <img src="app/views/default/img/img.png" style="float:rigth; margin-left:-2px;" width="35" height="40">
            <spam href="#" class="navbar-brand" style="color:blue">Redzpot</spam>
          </div>
        </div>
      </nav>

<div class="container">
      <center>
<div style="text-align: center;font-family: Impact">
    <h1 style="text-align: center;">Acceso Denegado.</h1>
    <img src="<?=$_SITE_HTTP?>app/views/default/img/homer_acceso_denegado.png"  height="50%" width="40%"/>
    <h1 style="text-align: center;">Si piensa que esto es un error, consulte al administrados del sistema.</h1>
</div>
</center>
<div>
<?php require_once('app/views/default/footer.php'); ?>
