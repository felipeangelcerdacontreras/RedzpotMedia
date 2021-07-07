<?php

/**
 * Created by PhpStorm.
 * User: pacorock
 * Date: 23/12/2016
 * Time: 08:47 PM
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/Redzpot.class.php");

class Clientes extends REDZPOT
{
    public $cli_id;
    public $cli_rfc;
    public $cli_nom_empresa;
    public $cli_nom_representante;
    public $cli_tel_representante;
    public $cli_tel_empresa;
    public $cli_correo_empresa;
    public $cli_direccion;
    public $cli_activo;
    public $cli_fecha_vigencia;
    public $cli_logo;
    public $cli_slogan;


    public function __construct($valores = null)
    {
        parent::__construct();

        if ($valores !== null) {
            foreach ($valores as $idx => $valor) {
                // protego que los valores vengan seguros
                $this->{$idx} = addslashes($valor);
            }
        }
    }

    public function Listado()
    {
        $sqlNomRepresentante = "";
        if (!empty($this->cli_nom_empresa)) {
            $sqlNomRepresentante = "and a.cli_nom_empresa like '%{$this->cli_nom_empresa}%'";
        }

        $sqlEstatus = "and a.cli_activo=true";
        if ($this->cli_activo == false && $this->cli_activo != "") {
            $sqlEstatus = "and a.cli_activo=false";
        } else if ($this->cli_activo == "T") {
            $sqlEstatus = "";
        }

        $sqlCliente = "";
        if (!empty($this->cli_id)) $sqlCliente = "and a.cli_id='{$this->cli_id}'";

        $sql = "select a.* from clientes as a where
                a.cli_nom_empresa like '%{$this->cli_nom_empresa}%'
                {$sqlEstatus}
                {$sqlNomRepresentante}
                {$sqlCliente}
                order by a.cli_nom_empresa";
        //echo nl2br($sql);
        return $this->Query($sql);
    }

    public function getInfo()
    {
        $sql = "select * from clientes where cli_id = '{$this->cli_id}'";
        $res = $this->Query($sql);

        if (count($res) > 0) {
            foreach ($res[0] as $idx => $campo) {
                $this->{$idx} = $campo;
            }
        }
    }

    public function Existe()
    {
        $sql = "select cli_id from clientes where cli_id='{$this->cli_id}'";
        $res = $this->Query($sql);
        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }

        return $bExiste;
    }

    public function Actualizar()
    {
        $sql = "update
                    clientes
                set
                  cli_rfc='{$this->cli_rfc}',
                  cli_nom_empresa='{$this->cli_nom_empresa}',
                  cli_nom_representante='{$this->cli_nom_representante}',
                  cli_tel_representante='{$this->cli_tel_representante}',
                  cli_tel_empresa='{$this->cli_tel_empresa}',
                  cli_correo_empresa='{$this->cli_correo_empresa}',
                  cli_direccion='{$this->cli_direccion}',
                  cli_activo='{$this->cli_activo}',
                  cli_fecha_vigencia='{$this->cli_fecha_vigencia}',
                  cli_logo='{$this->cli_logo}',
                  cli_slogan='{$this->cli_slogan}'
                where
                  cli_id='{$this->cli_id}';";
        //echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar()
    {
        $sql = "insert into clientes
              (`cli_rfc`,
                `cli_nom_empresa`,
                `cli_nom_representante`,
                `cli_tel_representante`,
                `cli_tel_empresa`,
                `cli_correo_empresa`,
                `cli_direccion`,
                `cli_activo`,
                `cli_fecha_vigencia`,
                `cli_logo`,
                `cli_slogan`)
                values
                ('{$this->cli_rfc}',
                '{$this->cli_nom_empresa}',
                '{$this->cli_nom_representante}',
                '{$this->cli_tel_representante}',
                '{$this->cli_tel_empresa}',
                '{$this->cli_correo_empresa}',
                '{$this->cli_direccion}',
                '{$this->cli_activo}',
                '{$this->cli_fecha_vigencia}',
                '{$this->cli_logo}',
                '{$this->cli_slogan}')";

        $bResultado = $this->NonQuery($sql);

        $sql = "select cli_id from clientes order by cli_id desc limit 1";
        $res = $this->Query($sql);

        $this->cli_id = $res[0]->cli_id; // obtengo el ID que le dio el sistema

        return $bResultado;
    }

    public function Guardar()
    {
        if (!$this->EsAdministrador()) {
            return false;
        }

        if ($this->Existe()) {
            return $this->Actualizar();
        } else {
            return $this->Agregar();
        }
    }

    public function Borrar()
    {
        if (!$this->EsAdministrador()) {
            return false;
        }

        $sql = "select * from clientes where cli_id='{$this->cli_id}'";
        $res = $this->Query($sql);

        @unlink($this->RutaAbsoluta . $res[0]->cli_logo);

        $sql = "delete from clientes where cli_id='{$this->cli_id}'";
        return $this->NonQuery($sql);
    }

    public function QuitarLogo()
    {
        if (!$this->EsAdministrador()) {
            return false;
        }

        $sql = "select cli_logo from clientes where cli_id='{$this->cli_id}'";
        $res = $this->Query($sql);

        @unlink($this->RutaAbsoluta . $res[0]->cli_logo);

        $sql = "update clientes set cli_logo=null where cli_id='{$this->cli_id}'";
        return parent::NonQuery($sql);
    }

    public function SubirArchivo($archivo)
    {
        if (!$this->EsAdministrador()) {
            return false;
        }

        $bResultado = false;
        $dirFotos = $this->RutaAbsoluta . "anexos";
        @mkdir($dirFotos);
        $dirFotos .= "/logos_clientes/";
        @mkdir($dirFotos);

        $archivoDir = "anexos/logos_clientes/";

        if ($archivo['error'] == 0) {// si se subió el archivo
            $nomArchivoTemp = explode(".", $archivo['name']);
            $extArchivo = strtoupper(trim(end($nomArchivoTemp)));

            if (!($extArchivo == "JPG" || $extArchivo == "PNG"))// si no es igual a jpg
                return 2;

            $nomArchivo = $this->cli_id . ".{$extArchivo}";
            $archivoDir .= $nomArchivo;
            $uploadfile = $dirFotos . basename($nomArchivo);

            if (move_uploaded_file($archivo['tmp_name'], $uploadfile)) {
                $sql = "update clientes set cli_logo='{$archivoDir}' where cli_id='{$this->cli_id}'";
                $bResultado = $this->NonQuery($sql);
            }
        }
        return $bResultado == 1 ? true : false;
    }
}
