<?php
/*
 * Copyright 2016 - Geodesarrollos Soluciones S de RL de CV
 * francisco.torres@geodesa.com.mx
 */
//require_once ($_SERVER ['DOCUMENT_ROOT'] . "/SOCIAL/Configuracion.class.php");

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "Configuracion.class.php");


class database extends Configuracion
{
    private $Link;

    // -----------------------------------------------------------------------------------
    public function __construct()
    {
        parent::__construct();

        $this->Link = mysqli_connect($this->mysql_host, $this->mysql_user, $this->mysql_pass, $this->mysql_database);
        @mysqli_set_charset($this->Link, 'utf8');

        if ($this->Link === false) {
            echo $this->MensajeAlerta("Base de Datos", "Conexión fallida al servidor {$this->mysql_host}, {$this->mysql_user}/{$this->mysql_pass}, Base de datos: {$this->mysql_database}");
            exit ();
        } else {
            $db_selected = mysqli_select_db($this->Link, $this->mysql_database);
            if ($db_selected === false) {
                echo $this->MensajeAlerta("Base de Datos", $this->GetMySQLError());
                exit ();
            }
        }
    }

    // -----------------------------------------------------------------------------------
    public function __destruct()
    {
        if ($this->Link !== false)
            mysqli_close($this->Link);
    }

    // -----------------------------------------------------------------------------------
    private function IsConected()
    {
        if ($this->Link === false) {
            echo $this->MensajeAlerta("Base de Datos", $this->MensajeAlerta("<p><b>No se encuentra conectado al servidor de base de datos.</b></p>"));
            return false;
        }
        return true;
    }

    // -----------------------------------------------------------------------------------
    private function GetMySQLError()
    {
        return $this->MensajeAlerta("Base de Datos", "Error [" . mysqli_errno($this->Link) . "]: " . mysqli_errno($this->Link));
    }

    private function GuardarBitacora($sql){
        // insert into usuarios values
        // update clientes set
        // delete from clientes
		$palabra = Array();
		$palabra = explode (" ", $sql);
		$ip = $this->getRealIP();
		$fecha = date("Y-m-d H:i:s");
        if ($palabra[0] == "insert" || $palabra[0] == "INSERT" || $palabra[0] == "update" || $palabra[0] == "UPDATE" || $palabra[0] == "delete" || $palabra[0] == "DELETE") {

            $sqlBitacor = "insert into bitacora (bit_query, usr_id, bit_fecha, bit_ip) 
			VALUES
				('".addslashes($sql)."',".$_SESSION['geodesk']->usr_id .", '".$fecha."', '".$ip."');";
            $this->IsConected();
			$res = mysqli_query($this->Link, $sqlBitacor);
            unset($res);
			//echo $sqlBitacor;
        }
    }

    // -----------------------------------------------------------------------------------
    public function Query($sql)
    {
        $this->IsConected();

        $res = mysqli_query($this->Link, $sql);

        if ($res === false) {
            echo $this->MensajeAlerta("Base de Datos", $this->GetMySQLError() . "<br /><code>{$sql}</code>");
            return false;
        }

        $oRow = array();
        $row = @mysqli_fetch_object($res);
        if ($row === false) {
            return NULL;
        } else {
            while ($row == true) {
                $oRow [] = $row;
                $row = @mysqli_fetch_object($res);
            }
        }

        unset ($row);
        mysqli_free_result($res);

        return $oRow;
    }

    // -----------------------------------------------------------------------------------
    public function NonQuery($sql, $bGuardarBitacora = true)
    {
        $this->IsConected();

        $res = mysqli_query($this->Link, $sql);
		
        if ($res == false) {
            echo $this->MensajeAlerta("Base de Datos", $this->GetMySQLError() . "<br /><code>SQL:{$sql}</code>");
            return false;
        }

        unset($res);

        if (! $bGuardarBitacora)
            $this->GuardarBitacora($sql);

        return true;
    }

    // -----------------------------------------------------------------------------------
    public function SelectDataBase($database)
    {
        $this->IsConected();

        $db_selected = @mysqli_select_db($this->Link, $database);
        if ($db_selected === false) {
            echo $this->MensajeAlerta("Base de Datos", $this->GetMySQLError());
            return false;
        }
        return true;
    }
    // ------------------------------------------------------------------------------
}

?>