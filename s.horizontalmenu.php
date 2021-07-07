<?php
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "Configuracion.class.php");

$oConfig = new Configuracion();

$sesion = $_SESSION[$oConfig->NombreSesion];

if ($_SESSION[$oConfig->NombreSesion]->usr_nivel == 1) {
    ?>
    <!-- MENÚ DE ADMINISTRACIÓN-->
    <ul class="nav">
        <li><a href="index.php?action=bienvenida">Inicio</a></li>

        <li><a href="#">Administración</a>
            <ul>
                <li><a href="index.php?action=sugerencias">Buzón de Sugerencias</a></li>
                <li><a href="index.php?action=clientes">Clientes</a></li>
                <li><a href="index.php?action=clientes_pagos">Clientes Pagos</a></li>
            </ul>
        </li>
        <li><a href="#">Catálogos</a>
            <ul>
                <li><a href="index.php?action=catalogo_productos">Productos</a></li>
                <li><a href="index.php?action=catalogo_inmobiliario">Inmobiliario</a></li>
                <li><a href="index.php?action=catalogo_herramientas">Herramientas</a></li>
                <li><a href="index.php?action=catalogo_proveedores">Proveedores</a></li>
                <li><a href="index.php?action=niveles">Niveles de Usuario</a></li>
                <li><a href="index.php?action=catalogo_usuarios">Usuarios</a></li>
                <li><a href="#">Flotillas</a>
                    <ul>
                        <li><a href="index.php?action=catalogo_flotillas_crear">Crear</a></li>
                        <li><a href="index.php?action=catalogo_flotillas_miembros">Miembros</a></li>
                    </ul>
                </li>
                <li><a href="index.php?action=catalogo_personal">Nóminas</a></li>
                <li><a href="index.php?action=bancos">Bancos</a></li>
            </ul>
        </li>
        <li><a href="#">Inventario</a>
            <ul>
                <li><a href="index.php?action=inventario_generar">Generar Inventario</a></li>
                <li><a href="index.php?action=inventario_registra">Capturar información de inventario</a></li>
                <li><a href="#">Historial de Inventarios</a></li>
                <li><a href="index.php?action=inventario_reportes">Reportes</a></li>
            </ul>
        </li>
        <li><a href="#">Almacén</a>
            <ul>
                <li><a href="index.php?action=almacen_ordenentrada">Ordenes de entrada</a></li>
                <li><a href="index.php?action=almacen_ordensalida">Ordenes de salida</a></li>
                <li><a href="index.php?action=almacen_prestamoherramienta">Prestamo de herramienta</a></li>
                <li><a href="index.php?action=almacen_devolucionherramienta">Devolución de Herramienta</a></li>
                <li><a href="index.php?action=almacen_merma">Registro de Merma</a></li>
            </ul>
        </li>
        <li><a href="#">Instalaciones</a>
            <ul>
                <li><a href="#">Luminarias</a>
                    <ul>
                        <li><a href="index.php?action=catalogo_luminarias">Lista</a></li>
                    </ul>
                </li>
                <li><a href="#">Edificios</a></li>
                <li><a href="index.php?action=instalaciones_reportes">Reportes de Instalación</a></li>
                <li><a href="index.php?action=instalaciones_manual">Checklist</a></li>
            </ul>
        </li>
        <li><a href="#">Mapas</a>
            <ul>
                <li><a href="app/views/default/modules/mapa/general">General (25,886)</a></li>
                <li><a href="app/views/default/modules/mapa/zonaa">Zona A (3,825)</a></li>
                <li><a href="app/views/default/modules/mapa/zonab">Zona B (2,262)</a></li>
                <li><a href="app/views/default/modules/mapa/zonac">Zona C (3,170)</a></li>
                <li><a href="app/views/default/modules/mapa/zonad">Zona D (3,150)</a></li>
                <li><a href="app/views/default/modules/mapa/zonae">Zona E (4,227)</a></li>
                <li><a href="app/views/default/modules/mapa/zonaf">Zona F (2,668)</a></li>
                <li><a href="app/views/default/modules/mapa/zonag">Zona G (Parques - 1,415)</a></li>
                <li><a href="app/views/default/modules/mapa/zonah">Zona H (Blvd - 5,169)</a></li>
            </ul>
        </li>
    </ul>
    <?php
}
?>

<?php
if ($_SESSION[$oConfig->NombreSesion]->usr_nivel == 2) {
    ?>
    <!-- MENÚ DE CONTRATISTAS-->
    <ul class="nav">
        <li><a href="index.php?action=bienvenida">Inicio</a></li>
        <li><a href="#">Catálogos</a>
            <ul>
                <li><a href="index.php?action=catalogo_productos">productos</a></li>
                <li><a href="#">Fichas Técnicas</a></li>
            </ul>
        </li>
        <li><a href="#">Almacén</a>
            <ul>
                <li><a href="#">Ordenes de entrada</a></li>
                <li><a href="#">Ordenes de salida</a></li>
                <li><a href="#">Peticiones de producto</a></li>
                <li><a href="#">Prestamo de Herramienta</a></li>
            </ul>
        </li>
        <li><a href="#">Instalaciones</a>
            <ul>
                <li><a href="#">Luminarias Instaladas</a></li>
                <li><a href="#">Luminarias pendientes</a></li>
                <li><a href="#">Luminarias no identificadas</a></li>
                <li><a href="#">Reportes de Instalación</a></li>
            </ul>
        </li>
        <li><a href="#">Mapas</a></li>
    </ul>
    <?php
}
?>
