<?php

/*
 * Copyright 2016 - Geodesarrollos Soluciones S de RL de CV
 * francisco.torres@geodesa.com.mx
 */
//require_once ($_SERVER['DOCUMENT_ROOT'] . "/SOCIAL/app/model/Reaccion.class.php");
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/Redzpot.class.php");

class usuarioscuenta extends REDZPOT {

    var $usr_id;
    var $usr_alias;
    var $usr_pass;
    var $usr_nombre;
    var $usr_nivel;
    var $usr_foto;
    var $cli_id;
    var $usr_correoe;

    public function __construct($sesion = true, $datos = NULL) {
        parent::__construct($sesion);

        if (!($datos == NULL)) {
            if (count($datos) > 0) {
                foreach ($datos as $idx => $valor) {
                    $this->{$idx} = addslashes($valor);
                }
            }
        }
    }

    public function Listado() {
        $sqlCliente = "";
        if (!empty($this->cli_id)) {
            $sqlCliente = "and a.cli_id='{$this->cli_id}'";
            if ($_SESSION[$this->NombreSesion]->usr_nivel > 1) {
                $sqlCliente .= " and a.usr_nivel > 1";
            }
        }

        $sql = "select a.*, b.*, c.nvl_nombre
                from usuarios as a
                inner join clientes as b on b.cli_id=a.cli_id
                left join niveles as c on c.nvl_id = a.usr_nivel
                where
                  a.usr_alias like '%{$this->usr_alias}%'
                  {$sqlCliente}";

        return $this->Query($sql);
    }

    public function Informacion() {
        $sql = "select * from usuarios where usr_id='{$this->usr_id}'";
        $res = parent::Query($sql);

        if (!empty($res) && !($res === NULL)) {
            foreach ($res [0] as $idx => $valor) {
                $this->{$idx} = $valor;
            }
        } else {
            $res = NULL;
        }

        return $res;
    }

    public function Existe() {
        $sql = "select usr_id from usuarios where usr_id='{$this->usr_id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }

        return $bExiste;
        //echo nl2br($bExiste." func");
    }

    public function Actualizar() {
        $sqlPass = "";
        if (!empty($this->usr_pass)) {
            $sqlPass = "usr_pass='{$this->Encripta($this->usr_pass)}',";
        }
        $sqlNivel = "";
        if (!empty($this->usr_nivel)) {
            $sqlNivel = "usr_nivel='{$this->usr_nivel}',";
        }
        $sqlCliente = "";
        if (!empty($this->cli_id)) {
            $sqlCliente = "cli_id='{$this->cli_id}',";
        }

        $sql = "update
                    usuarios
                set
                  usr_alias='{$this->usr_alias}',
                  usr_nombre='{$this->usr_nombre}',
                  {$sqlNivel}
                  {$sqlPass}
                  {$sqlCliente}
                  usr_correoe='{$this->usr_correoe}'
                where
                  usr_id='{$this->usr_id}'";

        //echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar() {
        $sql = "insert into usuarios
                (usr_id,usr_alias, usr_pass, usr_nombre, usr_nivel, cli_id, usr_correoe)
                values
                ('0','{$this->usr_alias}', '{$this->Encripta($this->usr_pass)}', '{$this->usr_nombre}', '{$this->usr_nivel}', '{$this->cli_id}', '{$this->usr_correoe}')";

        $bResultado = $this->NonQuery($sql);

        $sql1 = "select usr_id from usuarios order by usr_id desc limit 1";
        $res = $this->Query($sql1);

        $this->usr_id = $res[0]->usr_id; // obtengo el ID que le dio el sistema
        //echo nl2br($sql);
        return $bResultado;
    }

    public function Guardar() {
        
        $bRes = false;
        if ($this->Existe() === true) {
            $bRes = $this->Actualizar();
        } else {
            $bRes = $this->Agregar();
        }

        return $bRes;
    }

    public function SubirArchivo($archivo) {

        $bResultado = false;
        $dirFotos = $this->RutaAbsoluta . "perfil";
        @mkdir($dirFotos);
        $dirFotos .= "/clientes";
        @mkdir($dirFotos);
        $dirFotos .= "/{$this->cli_id}/";
        @mkdir($dirFotos);

        $archivoDir = "perfil/clientes/{$this->cli_id}/";

        if ($archivo['error'] == 0) {// si se subió el archivo
            $nomArchivoTemp = explode(".", $archivo['name']);
            $extArchivo = strtoupper(trim(end($nomArchivoTemp)));

            if (!($extArchivo == "JPG" || $extArchivo == "PNG")) {// si no es igual a jpg
                return 2;
            }

            $nomArchivo = $this->usr_id . ".{$extArchivo}";
            $archivoDir .= $nomArchivo;
            $uploadfile = $dirFotos . basename($nomArchivo);

            if (move_uploaded_file($archivo['tmp_name'], $uploadfile)) {
                $sql = "update usuarios set usr_foto='{$archivoDir}' where usr_id='{$this->usr_id}'";
                $bResultado = parent::NonQuery($sql);
                //echo nl2br($sql);
            }
        }
        return $bResultado == 1 ? true : false;
    }

    public function QuitarFoto() {
        $sql = "select usr_foto from usuarios where usr_id='{$this->usr_id}'";
        $res = $this->Query($sql);

        @unlink($this->RutaAbsoluta . $res[0]->usr_foto);
        $sql1 = "update usuarios set usr_foto=null where usr_id='{$this->usr_id}'";
        return parent::NonQuery($sql1);
    }

    public function ActualizarRutaFoto() {
        return true;
    }

    public function Borrar() {
        $sql = "select usr_foto from usuarios where usr_id='{$this->usr_id}'";
        $res = $this->Query($sql);

        @unlink($this->RutaAbsoluta . $res[0]->usr_foto);

        $sql1 = "delete from usuarios where usr_id='{$this->usr_id}'";
        return $this->NonQuery($sql1);
    }

}
