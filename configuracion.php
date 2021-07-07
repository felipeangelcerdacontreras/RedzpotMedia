<?php

class Configuracion {

	var $mysql_host = "127.0.0.1";
	var $mysql_user = "root";
	var $mysql_pass = "";
	var $mysql_database = "4lmacen";

    public function __construct() {
		// constructor de la clase
    }

    public function getRealIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDR'];
    }

}
