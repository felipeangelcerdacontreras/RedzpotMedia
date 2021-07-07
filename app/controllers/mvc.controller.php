<?php
/*
 * Copyright 2016 - Geodesarrollos Soluciones S de RL de CV
 * francisco.torres@geodesa.com.mx
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "Configuracion.class.php");
require_once($_SITE_PATH . "app/model/Redzpot.class.php");

class mvc_controller extends Configuracion
{
    public function __construct()
    {
        parent::__construct();
        /*
         * Constructor de la clase
         */
    }

    public function ExisteSesion()
    {
        if (!isset($_SESSION[$this->NombreSesion])) {
            echo "<script> window.location='index.php?action=login'; </script>";
            exit();
        }

    }

    public function CerrarSesion()
    {
        if (isset($_SESSION[$this->NombreSesion])) {
            session_unset();
            session_destroy();
        }

        echo "<script> window.location='index.php' </script>";
        exit();
    }

    public function login()
    {
        include_once("app/views/default/modules/login/m.login.php");
    }

    public function reproductor() {
        include "app/views/default/modules/spot/reproductor/m.reproductor.php";
    }


    protected function CargarModulo($titulo = "", $modulo = "")
    {
        $pagina = $this->load_template($titulo);
        ob_start();

        include_once($modulo);
        $contenido = ob_get_clean();
        @ob_end_clean();

        $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $contenido, $pagina);
        $this->view_page($pagina);
    }

    public function acceso_denegado()
    {
        include_once("app/views/default/modules/m.acceso_denegado.php");
    }

    public function error_page()
    {
        include_once("app/views/default/modules/m.error_page.php");
    }

    // CARGAR PLANTILLA
    protected function load_template($title = 'Geodesk')
    {
        $pagina = $this->load_page('app/views/default/page.php');

        // Para cargar el Menu
        ob_start();
        include_once("app/views/default/sections/s.horizontalmenu.php");
        $menu_horizontal = ob_get_clean();
        @ob_end_clean();

        // Para cargar la columna derecha
        ob_start();
        include_once("app/views/default/sections/s.rightmenu.php");
        $right_menu = ob_get_clean();
        @ob_end_clean();

        $pagina = $this->replace_content('/\#HEADER\#/ms', $this->load_header(), $pagina);
        $pagina = $this->replace_content('/\#TITLE\#/ms', $title, $pagina);
        $pagina = $this->replace_content('/\#HORIZONTALMENU\#/ms', $menu_horizontal, $pagina);
        $pagina = $this->replace_content('/\#RIGHTMENU\#/ms', $right_menu, $pagina);

        return $pagina;
    }

    // LEER PÁGINA
    protected function load_header()
    {
        ob_start();
        $sesion = NULL;
        if (isset($_SESSION[$this->NombreSesion])) {
            $sesion = $_SESSION[$this->NombreSesion];
        }

        include_once("app/views/default/sections/s.header.php");

        $header = ob_get_clean();
        @ob_end_clean();
        return $header;
    }

    protected function load_page($page)
    {
        return file_get_contents($page);
    }

    // MOSTRAR PÁGINA
    protected function view_page($html)
    {
        echo $html;
    }

    protected function replace_content($in = '/\#CONTENIDO\#/ms', $out, $pagina)
    {
        return preg_replace($in, $out, $pagina);
    }
}

?>
