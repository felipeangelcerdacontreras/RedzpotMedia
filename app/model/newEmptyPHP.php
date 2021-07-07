<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $reporte = null;
for($x=0; $x<count($_FILES["file"]["name"]); $x++)
    {
      $file = $_FILES["file"];
      $nombre = $file["name"][$x];
      $tipo = $file["type"][$x];
      $ruta_provisional = $file["tmp_name"][$x];
      $size = $file["size"][$x];
      $dimensiones = getimagesize($ruta_provisional);
      $width = $dimensiones[0];
      $height = $dimensiones[1];
      $carpeta = "tu_ruta/";

      if ($tipo != 'image/jpeg' && $tipo != 'image/jpg' && $tipo != 'image/png' && $tipo != 'image/gif')
      {
          $reporte .= "<p style='color: red'>Error $nombre, el archivo no es una imagen.</p>";
      }
      else if($size > 1024*1024)
      {
          $reporte .= "<p style='color: red'>Error $nombre, el tamaño máximo permitido es 1mb</p>";
      }
      else if($width > 500 || $height > 500)
      {
          $reporte .= "<p style='color: red'>Error $nombre, la anchura y la altura máxima permitida es de 500px</p>";
      }
      else if($width < 60 || $height < 60)
      {
          $reporte .= "<p style='color: red'>Error $nombre, la anchura y la altura mínima permitida es de 60px</p>";
      }
      else
      {
          $src = $carpeta.$nombre;

          //Caragamos imagenes al servidor
          move_uploaded_file($ruta_provisional, $src);       

          //Codigo para insertar imagenes a tu Base de datos.
          //Sentencia SQL

          echo "<p style='color: blue'>La imagen $nombre ha sido subida con éxito</p>";
      }
      
      
       public function SubirArchivo($archivo) {
        if (!$this->EsAdministrador()) {
            return false;
        }
        $reporte = null;
        for ($x = 0; $x < count($_FILES["foto"]["name"]); $x++) {

            $bResultado = false;
            $file = $_FILES["foto"];
            $ruta_provisional = $file["tmp_name"][$x];
            $tipo = $file["type"][$x];
            $size = $file["size"][$x];
            $dimensiones = getimagesize($ruta_provisional);
            $width = $dimensiones[0];
            $height = $dimensiones[1];

            $dirFotos = $this->RutaAbsoluta . "anexos";
            @mkdir($dirFotos);
            $dirFotos .= "clientes/";
            @mkdir($dirFotos);



            $archivoDir = "spot/imagenes/";
            if ($tipo != 'image/jpeg' && $tipo != 'image/jpg' && $tipo != 'image/png' && $tipo != 'image/gif') {
                return 2;
            } else if ($size > 1024 * 1024) {
                $reporte .= "<p style='color: red'>Error $nombre, el tamaño máximo permitido es 1mb</p>";
            } else if ($width > 500 || $height > 500) {
                $reporte .= "<p style='color: red'>Error $nombre, la anchura y la altura máxima permitida es de 500px</p>";
            } else if ($width < 60 || $height < 60) {
                $reporte .= "<p style='color: red'>Error $nombre, la anchura y la altura mínima permitida es de 60px</p>";
            }
            if ($archivo['error'] == 0) {// si se subió el archivo
                $nomArchivoTemp = explode(".", $archivo['name']);
                echo $nomArchivoTemp;
                $extArchivo = strtoupper(trim(end($nomArchivoTemp)));

                $nomArchivo = $this->spo_id . ".{$extArchivo}";
                $archivoDir .= $nomArchivo;
                echo $archivoDir;
                $uploadfile = $dirFotos . basename($nomArchivo);

                if (move_uploaded_file($archivo['tmp_name'], $uploadfile)) {
                    $sql = "update spots set cli_logo='{$archivoDir}' where spo_id='{$this->spo_id}'";
                    $bResultado = $this->NonQuery($sql);
                }
            }
            return $bResultado == 1 ? true : false;
        }
    }
    
    
    
    <div class="form-group">
                <label class="control-label col-sm-2">Archivo de foto:</label>
                <div class="col-sm-10">
                    <input type="file" id="foto" name="foto" value="" multiple=""/>
                    <!--<img id="imgFoto" name="imgFoto" src="<?= $oUsuario->usr_foto ?>" width="64" style="height:40%;" border="0" class="form-control"/><br/>
                    <input type="button" id="btnQuitarFoto" name="btnQuitarFoto" value="Quitar" class="form-control"/>-->
                </div>
            </div>