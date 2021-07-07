<?php
/*
 * Copyright 2016 - Geodesarrollos Soluciones S de RL de CV
 * francisco.torres@geodesa.com.mx
 */

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/Redzpot.class.php");

class niveles extends REDZPOT
{
    public $nvl_id;
    public $nvl_nombre;
    public $nvl_permisos;
    public $cli_id;

    public function __construct($valida_sesion = true, $datos = NULL)
    {
        parent::__construct($valida_sesion);

        if (!($datos == NULL)) {
            if (count($datos) > 0) {
                foreach ($datos as $idx => $valor) {
                    if (gettype($valor) === "array") {
                        $this->{$idx} = $valor;
                    } else {
                        $this->{$idx} = addslashes($valor);
                    }
                }
            }
        }
    }

    public function Listado()
    {
        $sqlCliente = "";
        if (!empty($this->cli_id)) {
            $sqlCliente = "where cli_id='{$this->cli_id}'";
        }

        $sql = "select * from niveles {$sqlCliente}";
        return $this->Query($sql);
    }

    public function Informacion()
    {
        $sql = "select * from niveles where nvl_id = '{$this->nvl_id}'";

        $res = $this->Query($sql);

        if (!empty($res) && !($res === NULL)) {
            foreach ($res [0] as $idx => $valor) {
                $this->{$idx} = $valor;
            }
        } else {
            $res = NULL;
        }

        return $res;
    }

    public function Existe()
    {
        $sql = "select nvl_id from niveles where nvl_id='{$this->nvl_id}'";
        $res = $this->Query($sql);

        $bExiste = false;
        if (count($res) > 0) {
            $bExiste = true;
        }

        return $bExiste;
    }

    public function Actualizar()
    {
        $sPermisos = "";
        if (! empty($this->nvl_permisos)) {
            foreach ($this->nvl_permisos as $idx => $valor) {
                $sPermisos .= $valor . "@";
            }
        }

        $sql = "update
                  niveles
                set
                  nvl_nombre = '{$this->nvl_nombre}',
                  nvl_permisos = '{$sPermisos}',
                  cli_id = '{$this->cli_id}'
                where
                  nvl_id='{$this->nvl_id}'";
        return $this->NonQuery($sql);
    }

    public function Agregar()
    {
        $sPermisos = "";
        if ($sPermisos && count($sPermisos) > 0) {
            foreach ($this->nvl_permisos as $idx => $valor) {
                $sPermisos .= $valor . "@";
            }
        }

        $sql = "insert into niveles (nvl_nombre, nvl_permisos, cli_id)
                values ('{$this->nvl_nombre}', '{$sPermisos}', '{$this->cli_id}')";

        return $this->NonQuery($sql);
    }

    public function Guardar()
    {
        if ($this->Existe() === false) {
            return $this->Agregar();
        } else {
            return $this->Actualizar();
        }
    }

    public function Borrar()
    {
        $sql = "delete from niveles where nvl_id='{$this->nvl_id}'";
        return $this->NonQuery($sql);
    }

}
