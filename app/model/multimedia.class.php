<?php

/*
 * Copyright 2019 - Redzpot, Departamento de Innovación Tecnologica 
 * cerda@redzpot.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/Redzpot.class.php");

class Multimedia extends REDZPOT {

    var $mul_id;
    var $cli_id;
    var $mul_ruta;
    var $mul_tipo;
    var $mul_orden;

    ////////////////////////variable de busqueda

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

        $sql = "select a.*,b.cli_nom_empresa,b.cli_activo,c.cli_id from multimedia as a join clientes as b on a.cli_id=b.cli_id
        join spots as c on c.cli_id=b.cli_id 
        where b.cli_id = '{$this->cli_id}' and b.cli_activo like '%{$this->cli_activo}%' order by a.mul_orden";
        //echo nl2br($sql);
        return $this->Query($sql);
    }

    public function Informacion() {
        $sql = "select * from MULTIMEDIA where mul_id='{$this->mul_id}'";
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
        $sql = "select mul_id from multimedia where mul_id='{$this->mul_id}'";
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
                    multimedia
                set
                  cli_id='{$this->cli_id}',
                  mul_ruta='{$this->mul_ruta}'
                where
                  mul_id='{$this->mul_id}'";

        //echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar() {
        $sql = "insert into multimedia
                (mul_id,cli_id, mul_ruta)
                values
                ('0','{$this->cli_id}', '{$this->mul_ruta}')";

        $bResultado = $this->NonQuery($sql);

        $sql1 = "select mul_id from multimedia order by mul_id desc limit 1";
        $res = $this->Query($sql1);

        $this->mul_id = $res[0]->mul_id; // obtengo el ID que le dio el sistema
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
        $dirArchivo .= "/multimedia";
        @mkdir($dirArchivo);
        $dirArchivo .= "/{$this->cli_id}/";
        @mkdir($dirArchivo);

        $archivoDir = "spots/multimedia/{$this->cli_id}/";

        if ($archivo['error'] == 0) {// si se subió el archivo
            $nomArchivoTemp = explode(".", $archivo['name']);
            $extArchivo = strtoupper(trim(end($nomArchivoTemp)));
            
            if (!($extArchivo == "MP4" || $extArchivo == "JPG" || $extArchivo == "PNG" || $extArchivo == "JPGE")) {// si no es igual a mp4
                return 2;
            }

            $nomArchivo = $this->mul_id . ".{$extArchivo}";
            $archivoDir .= $nomArchivo;
            $uploadfile = $dirArchivo . basename($nomArchivo);
            //echo $uploadfile." ";
            //print_r($archivo); 

            if (move_uploaded_file($archivo['tmp_name'],  $uploadfile)) {
                $sql = "update multimedia set mul_ruta='{$archivoDir}', mul_tipo='{$extArchivo}'  where mul_id='{$this->mul_id}'";
                $bResultado = parent::NonQuery($sql);
                //echo nl2br($sql);
            }
       }
       return $bResultado == 1 ? true : false;
    }
    public function GenerarLista($id,$orden) {
        $res = 0;
        $sql = "update
                    multimedia
                set
                  mul_orden='{$orden}'
                where
                  mul_id='{$id}'";

        if ($this->NonQuery($sql)){
            $res = 3;
        }
        return $res;
    }
    public function CrearTxt($id) {
        $sql = "select a.*,b.cli_nom_empresa,b.cli_activo,c.cli_id from multimedia as a join clientes as b on a.cli_id=b.cli_id
        join spots as c on c.cli_id=b.cli_id 
        where b.cli_id = '{$id}' and b.cli_activo like '%1%' order by a.mul_orden";
        //echo nl2br($sql);
        return $this->Query($sql);

    }
    function eliminar_simbolos($string){
 
        $string = trim($string);
     
        $string = str_replace(
            array("\'"),
            "'",
            $string
        );
    return $string;
    } 
    public function GeneraTxt($id,$texto){
         $texto = $this->eliminar_simbolos($texto);
         //echo $texto;

        $bResultado = false;
       
        $dirArchivo = $this->RutaAbsoluta . "spots";
        @mkdir($dirArchivo);
        $dirArchivo .= "/lista";
        @mkdir($dirArchivo);
        $dirArchivo .= "/$id/";
        @mkdir($dirArchivo);

        $archivoDir = "spots/lista/$id/$id.txt";
        //echo $texto;

        if($fp = fopen($this->RutaAbsoluta .$archivoDir, "w"))
        {
            if(fwrite($fp, $texto))
            {
               return true;
            }
            else
            {
                return false;
            }
            fclose($fp);
        }
    }

    public function Quitar() {
        $sql = "select mul_ruta from multimedia where mul_id='{$this->mul_id}'";
        $res = $this->Query($sql);
        //echo nl2br($sql);
        @unlink($this->RutaAbsoluta . $res[0]->mul_ruta);
        $sql1 = "update multimedia set mul_ruta=null, mul_tipo=null where mul_id='{$this->mul_id}'";
        //echo nl2br($sql1);
        return parent::NonQuery($sql1);
    }

    public function ActualizarRutaFoto() {
        return true;
    }

    public function Borrar() {
        $sql = "select mul_ruta from multimedia where mul_id='{$this->mul_id}'";
        $res = $this->Query($sql);

        @unlink($this->RutaAbsoluta . $res[0]->mul_ruta);

        $sql1 = "delete from multimedia where mul_id='{$this->mul_id}'";
        return $this->NonQuery($sql1);
    }

}