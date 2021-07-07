<?php

/*
 * Copyright 2019 - Redzpot, Departamento de Innovación Tecnologica 
 * cerda@redzpot.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/Redzpot.class.php");

class Lista extends REDZPOT {

    var $cli_id;
    var $vid_ruta;
    var $img_ruta;
    var $orden; 

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

        $sql = "select img_ruta, orden from imagen where cli_id = '{$this->cli_id}' union all select vid_ruta, orden  from video where cli_id = '{$this->cli_id}' order by orden ";
        echo nl2br($sql);
        return $this->Query($sql);
    }

    public function Informacion() {
        $sql = "select * from video where vid_id='{$this->vid_id}'";
        $res = parent::Query($sql);
        echo nl2br($sql);
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
        $sql = "select vid_id from video where vid_id='{$this->vid_id}'";
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
                    video
                set
                  cli_id='{$this->cli_id}',
                  vid_ruta='{$this->vid_ruta}'
                where
                  vid_id='{$this->vid_id}'";

        //echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar() {
        $sql = "insert into video
                (vid_id,cli_id, vid_ruta)
                values
                ('0','{$this->cli_id}', '{$this->vid_ruta}')";

        $bResultado = $this->NonQuery($sql);

        $sql1 = "select vid_id from video order by vid_id desc limit 1";
        $res = $this->Query($sql1);

        $this->vid_id = $res[0]->vid_id; // obtengo el ID que le dio el sistema
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
        $dirArchivo .= "/video";
        @mkdir($dirArchivo);
        $dirArchivo .= "/{$this->cli_id}/";
        @mkdir($dirArchivo);

        $archivoDir = "spots/video/{$this->cli_id}/";

        if ($archivo['error'] == 0) {// si se subió el archivo
            $nomArchivoTemp = explode(".", $archivo['name']);
            $extArchivo = strtoupper(trim(end($nomArchivoTemp)));
            
            if (!($extArchivo == "MP4")) {// si no es igual a mp4
                return 2;
            }

            $nomArchivo = $this->vid_id . ".{$extArchivo}";
            $archivoDir .= $nomArchivo;
            $uploadfile = $dirArchivo . basename($nomArchivo);
            echo $uploadfile." ";
            print_r($archivo); 

            if (move_uploaded_file($archivo['tmp_name'],  $uploadfile)) {
                $sql = "update video set vid_ruta='{$archivoDir}' where vid_id='{$this->vid_id}'";
                $bResultado = parent::NonQuery($sql);
                echo nl2br($sql);
            }
       }
    }

    public function Quitar() {
        $sql = "select vid_ruta from video where vid_id='{$this->vid_id}'";
        $res = $this->Query($sql);
        echo nl2br($sql);
        @unlink($this->RutaAbsoluta . $res[0]->vid_ruta);
        $sql1 = "update video set vid_ruta=null where vid_id='{$this->vid_id}'";
        echo nl2br($sql1);
        return parent::NonQuery($sql1);
    }

    public function ActualizarRutaFoto() {
        return true;
    }

    public function Borrar() {
        $sql = "select vid_ruta from video where vid_id='{$this->vid_id}'";
        $res = $this->Query($sql);

        @unlink($this->RutaAbsoluta . $res[0]->usr_foto);

        $sql1 = "delete from video where vid_id='{$this->vid_id}'";
        return $this->NonQuery($sql1);
    }

}
