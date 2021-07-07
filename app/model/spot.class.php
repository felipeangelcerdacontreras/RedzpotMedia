<?php

/**
 * Created by PhpStorm.
 * User: pacorock
 * Date: 23/12/2016
 * Time: 08:47 PM
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/Redzpot.class.php");

class Spot extends REDZPOT {

    public $spo_id;
    public $cli_id;
    public $spo_ban;
    public $spo_text;
    public $spo_text_ruta;
//variables de busqueda
    public $cli_nom_empresa;
    public $cli_activo;

    public function __construct($valores = null) {
        parent::__construct();

        if ($valores !== null) {
            foreach ($valores as $idx => $valor) {
// protego que los valores vengan seguros
                $this->{$idx} = addslashes($valor);
            }
        }
    }

    public function Listado() {
        $sqlNomRepresentante = "";
        if (!empty($this->cli_nom_empresa)) {
            $sqlNomRepresentante = "and b.cli_nom_empresa like '%{$this->cli_nom_empresa}%'";
        }
        $sqlEstatus = "and b.cli_activo=true";
        if ($this->cli_activo == false && $this->cli_activo != "") {
            $sqlEstatus = "and b.cli_activo=false";
        } else if ($this->cli_activo == "T") {
            $sqlEstatus = "";
        }

        $sql = "select a.*,b.cli_nom_empresa,b.cli_activo from spots as a join clientes as b on a.cli_id=b.cli_id where
                b.cli_nom_empresa like '%{$this->cli_nom_empresa}%'
                {$sqlEstatus}
                {$sqlNomRepresentante}
                order by b.cli_nom_empresa";
//echo nl2br($sql);
        return $this->Query($sql);
    }

    public function getInfo() {
        $sql = "select * from spots where spo_id = '{$this->spo_id}'";
        $res = $this->Query($sql);
        //echo nl2br($sql);
        if (count($res) > 0) {
            foreach ($res[0] as $idx => $campo) {
                $this->{$idx} = $campo;
            }
        }
    }

    public function Existe() {
        $sql = "select spo_id from spots where spo_id='{$this->spo_id}'";
        $res = $this->Query($sql);
        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }

        return $bExiste;
    }

    public function Actualizar() {
        $sql = "update
                    spots
                set
                  cli_id='{$this->cli_id}',
                  spo_ban='{$this->spo_ban}',
                  spo_text='{$this->spo_text}'
                where
                  spo_id='{$this->spo_id}';";
//echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar() {
        $sql = "insert into spots
              (`spo_id`,
                `cli_id`,
                `spo_ban`,
                `spo_text`)
                values
                ('{$this->spo_id}',
                '{$this->cli_id}',
                 '{$this->spo_ban}',
                '{$this->spo_text}')";

        $bResultado = $this->NonQuery($sql);

        $sql1 = "select spo_id from spots order by spo_id desc limit 1";
        $res = $this->Query($sql1);

        $this->spo_id = $res[0]->spo_id; // obtengo el ID que le dio el sistema

        return $bResultado;
    }

    public function CrearTxt($id) {
        $this->cli_id = $id;
        $bResultado = false;
        
        $dirArchivo = $this->RutaAbsoluta . "spots";
        @mkdir($dirArchivo);
        $dirArchivo .= "/texto";
        @mkdir($dirArchivo);
        $dirArchivo .= "/{$this->cli_id}/";
        @mkdir($dirArchivo);

        $archivoDir = "spots/texto/$this->cli_id/$this->cli_id.txt";
        //echo $archivoDir;

    $fp = fopen($this->RutaAbsoluta .$archivoDir, "w");
        fwrite($fp, $this->spo_text);
        fclose($fp);

        $sql = "update spots set spo_text_ruta='{$archivoDir}' where spo_id='{$this->spo_id}'";
        $bResultado = $this->NonQuery($sql);
        return $bResultado == 1 ? true : false;
    }

    public function Guardar() {
        if (!$this->EsAdministrador()) {
            return false;
        }

        if ($this->Existe()) {
            return $this->Actualizar();
        } else {
            return $this->Agregar();
        }
    }

    public function Borrar() {
        if (!$this->EsAdministrador()) {
            return false;
        }

        $sql = "select * from spots where spo_id='{$this->spo_id}'";
        $res = $this->Query($sql);

        @unlink($this->RutaAbsoluta . $res[0]->cli_logo);

        $sql = "delete from spots where spo_id='{$this->spo_id}'";
        return $this->NonQuery($sql);
    }

    public function QuitarLogo() {
        if (!$this->EsAdministrador()) {
            return false;
        }

        $sql = "select cli_logo from spots where spo_id='{$this->spo_id}'";
        $res = $this->Query($sql);

        @unlink($this->RutaAbsoluta . $res[0]->cli_logo);

        $sql = "update spots set cli_logo=null where spo_id='{$this->spo_id}'";
        return parent::NonQuery($sql);
    }

}
