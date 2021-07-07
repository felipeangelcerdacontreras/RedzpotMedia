<?php
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/Geodesk.class.php");

class Buzon extends GEODESK
{
    public $buz_id;
    public $cli_id;
    public $cliente_name;
    public $usr_id;
    public $usr_name;
    public $buz_fecha;
    public $buz_comentario;
    public $buz_max;

    public function __construct($valida_sesion = true, $datos = NULL)
    {
        parent::__construct($valida_sesion);

        if (!($datos == NULL)) {
            if (count($datos) > 0) {
                foreach ($datos as $idx => $valor) {
                    $this->{$idx} = $valor;
                }
            }
        }
    }


    public function Guardar()
    {
        $cliid = $_SESSION[$this->NombreSesion]->cli_id;
        $usrid = $_SESSION[$this->NombreSesion]->usr_id;
        $usrname = $_SESSION[$this->NombreSesion]->usr_alias;

        $sql = "insert into buzon (cli_id, usr_id, usr_name, buz_comentario)
                values(
                '$cliid',
                '$usrid',
                '$usrname',
                '{$this->buz_comentario}'
              );";

        $res = $this->NonQuery($sql);
        return $res;
    }

    public function lista2()
    {

        $sql = "select a.*
                from 
                usuarios as a 
                join clientes as b on b.cli_id=a.cli_id
                where  b.cli_nom_empresa like '%{$this->cliente_name}%';";


        $res = parent::Query($sql);
        //echo $sql;
        return $res;

    }


    public function Lista()
    {
        $sqlcli = "";
        if (!empty($this->cliente_name)) {
            $sqlcli = "and b.cli_nom_empresa like '%{$this->cliente_name}%'";
        }

        $sqlusr = "";
        if (!empty($this->usr_name)) {
            $sqlusr = "and a.usr_name like '%{$this->usr_name}%'";
        }

        $sqlfecha = "";
        if (!empty($this->buz_fecha) and !empty($this->buz_fecha2)) {
            $sqlfecha = "and date(a.buz_fecha)  between  '{$this->buz_fecha}' and '{$this->buz_fecha2}'";
        }

        $sqlcomentario = "";
        if (!empty($this->buz_comentario)) {
            $sqlcomentario = "and a.buz_comentario like '%{$this->buz_comentario}%'";
        }

        $sql = "select a.*, b.cli_nom_empresa, b.cli_logo
                from 
                  buzon as a 
                  join clientes as b on b.cli_id=a.cli_id
                where 
                a.buz_id
                {$sqlcli}
                {$sqlusr}
                {$sqlfecha}
                {$sqlcomentario} 
				order by buz_fecha desc";
        $res = parent::Query($sql);

        return $res;

    }


}

?>
