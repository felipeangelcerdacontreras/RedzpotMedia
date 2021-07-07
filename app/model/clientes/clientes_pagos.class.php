<?php

/**
 * Created by PhpStorm.
 * User: pacorock
 * Date: 23/12/2016
 * Time: 08:47 PM
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/clientes/clientes.class.php");

class Clientes_Pagos extends Clientes
{
    /*
     * CLASE PARA REGISTRAR LOS PAGOS DE LOS CLIENTES
     */
    public $pag_id;
    // public $cli_id; // Lo heredo de clase Clientes
    public $pag_referencia;
    public $pag_fecha;
    public $pag_importe;
    public $pag_cuenta;
    public $pag_medio;
    public $pag_forma;
    public $pag_sucursal;

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
        $sql = "select a.*, b.cli_rfc, b.cli_nom_empresa
                from clientes_pagos as a
                join clientes as b on b.cli_id=a.cli_id
                order by a.pag_fecha desc";
        return $this->Query($sql);
    }

    public function getInfo()
    {

    }

    public function Existe()
    {

    }

    public function Actualizar()
    {

    }

    public function Agregar()
    {

    }

    public function Guardar()
    {
        if ($this->Existe())
            return $this->Actualizar();
        else
            return $this->Agregar();
    }

    public function Borrar()
    {
    }
}