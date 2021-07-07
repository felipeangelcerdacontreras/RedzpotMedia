<?php
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "Configuracion.class.php");

$oConfig = new Configuracion();

$sesion = $_SESSION[$oConfig->NombreSesion];
?>
<script>
    $(document).ready(function (e) {
        $("#btnCerrarSesion").button().click(function (e) {
            document.location = "index.php?action=cerrar_sesion";
        });
    });
</script>
<!DOCTYPE html PUBLIC >
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html;" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ADMIN</title>
    </head>
    <style>
    </style>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>
                <img src="app/views/default/img/img.png" style="float:rigth; margin-left:-2px;" width="35" height="40">
                <a class="navbar-brand" href="index.php?action=bienvenida" style="color:blue">RedzPot</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php?action=micuenta"> Mi Cuenta</a>
                    </li>
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a  href="#" class="dropdown-toggle" data-toggle="dropdown">Catalogos<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li >
                                    <a  tabindex="-1" href="index.php?action=clientes" >Clientes</a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="index.php?action=usuarios">Usuarios</a>
                                </li>
                                <li >

                                    <a  tabindex="-1" href="index.php?action=niveles" >Niveles</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a  href="#" class="dropdown-toggle" data-toggle="dropdown">Spots<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a tabindex="-1" href="index.php?action=spot">Spot</a>
                                </li>
                                <li>
                                    <a tabindex="-1" href="index.php?action=spot_multimedia">Multimedia</a>
                                </li>
                                <li >
                                    <a  tabindex="-1" href="index.php?action=reproductor" >Reproductor</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </ul>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a>Usuario:  <?= $sesion->usr_alias ?></a></li>
                    <li><input class="btn btn-danger navbar-btn" type="button" id="btnCerrarSesion" name="btnCerrarSesion" value="Cerrar Sesión"/></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
