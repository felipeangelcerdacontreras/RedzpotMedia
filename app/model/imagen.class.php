<?php

/*
 * Copyright 2019 - Redzpot, Departamento de Innovación Tecnologica 
 * cerda@redzpot.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/Redzpot.class.php");

class Imagen extends REDZPOT {

    var $img_id;
    var $cli_id;
    var $img_ruta;

    ////////////////////////variable de busqueda
    var $cli_nom_empresa;
    var $cli_activo;

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

        $sql = "select a.*,b.cli_nom_empresa,b.cli_activo from imagen as a join clientes as b on a.cli_id=b.cli_id where b.cli_nom_empresa like '{$this->cli_nom_empresa}%'and b.cli_activo like '%{$this->cli_activo}%'";
        echo nl2br($sql);
        return $this->Query($sql);
    }

    public function Informacion() {
        $sql = "select * from imagen where img_id='{$this->img_id}'";
        $res = parent::Query($sql);
        //echo nl2br($sql);
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
        $sql = "select img_id from imagen where img_id='{$this->img_id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }

        return $bExiste;
        //echo nl2br($bExiste." func");
    }

    public function Actualizar() {

        $sql = "update
                    imagen
                set
                  cli_id='{$this->cli_id}',
                  img_ruta='{$this->img_ruta}'
                where
                  img_id='{$this->img_id}'";

        //echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar() {
        $sql = "insert into imagen
                (img_id,cli_id, img_ruta)
                values
                ('0','{$this->cli_id}', '{$this->img_ruta}')";

        $bResultado = $this->NonQuery($sql);

        $sql1 = "select img_id from imagen order by img_id desc limit 1";
        $res = $this->Query($sql1);

        $this->img_id = $res[0]->img_id; // obtengo el ID que le dio el sistema
        //echo nl2br($sql1);
        return $bResultado;
    }

    public function Guardar() {
        if (!$this->EsAdministrador()) {
            return false;
        }

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
        $dirArchivo = $this->RutaAbsoluta . "spots";
        @mkdir($dirArchivo);
        $dirArchivo .= "/imagen";
        @mkdir($dirArchivo);
        $dirArchivo .= "/{$this->cli_id}/";
        @mkdir($dirArchivo);

        $archivoDir = "spots/imagen/{$this->cli_id}/";
        print_r($archivo);
        if ($archivo['error'] == 0) {// si se subió el archivo
            $nomArchivoTemp = explode(".", $archivo['name']);
            $extArchivo = strtoupper(trim(end($nomArchivoTemp)));

            if (!($extArchivo == "JPG" || $extArchivo == "PNG")) {// si no es igual a jpg
                return 2;
            }

            $nomArchivo = $this->img_id . ".{$extArchivo}";
            $archivoDir .= $nomArchivo;
            $uploadfile = $dirArchivo . basename($nomArchivo);

            if (move_uploaded_file($archivo['tmp_name'], $uploadfile)) {
                $sql = "update imagen set img_ruta='{$archivoDir}' where img_id='{$this->img_id}'";
                $bResultado = parent::NonQuery($sql);
                //echo nl2br($sql);
            }
        }
        return $bResultado == 1 ? true : false;
    }

    public function QuitarFoto() {
        $sql = "select img_ruta from imagen where img_id='{$this->img_id}'";
        $res = $this->Query($sql);
        echo nl2br($sql);
        @unlink($this->RutaAbsoluta . $res[0]->usr_foto);
        $sql1 = "update imagen set img_ruta=null where img_id='{$this->img_id}'";
        echo nl2br($sql1);
        return parent::NonQuery($sql1);
    }

    public function ActualizarRutaFoto() {
        return true;
    }

    public function Borrar() {
        $sql = "select img_ruta from imagen where img_id='{$this->img_id}'";
        $res = $this->Query($sql);

        @unlink($this->RutaAbsoluta . $res[0]->usr_foto);

        $sql1 = "delete from imagen where img_id='{$this->img_id}'";
        return $this->NonQuery($sql1);
    }

}
