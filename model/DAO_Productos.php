<?php

include_once 'class.DAO.php'; 

class DAO_Productos extends DAOGeneral {

    protected $_prod_id;
    protected $_prod_nombre;
    protected $_prod_precio;
    protected $_prod_marca;
    protected $_prod_referencia;
    protected $_prod_estado;

    protected $_tabla = 'productos';
    
    protected $_mapa = [
        'prod_id' => ['tipodato' => 'varchar'],
        'prod_nombre' => ['tipodato' => 'varchar'],
        'prod_precio' => ['tipodato' => 'varchar'],
        'prod_referencia' => ['tipodato' => 'varchar'],
        'prod_estado' => ['tipodato' => 'varchar'],
        'prod_marca' => ['tipodato' => 'varchar']
    ];
    protected $_primario = 'prod_id';

    function get_prod_id() {
        return $this->_prod_id;
    }

    function get_prod_nombre() {
        return $this->_prod_nombre;
    }

    function get_prod_precio() {
        return $this->_prod_precio;
    }

    function get_prod_referencia() {
        return $this->_prod_referencia;
    }

    function get_prod_estado() {
        return $this->_prod_estado;
    }

    function set_prod_id($_prod_id) {
        $this->_prod_id = $_prod_id;
    }

    function set_prod_nombre($_prod_nombre) {
        $this->_prod_nombre = $_prod_nombre;
    }

    function set_prod_precio($_prod_precio) {
        $this->_prod_precio = $_prod_precio;
    }

    function set_prod_referencia($_prod_referencia) {
        $this->_prod_referencia = $_prod_referencia;
    }

    function set_prod_estado($_prod_estado) {
        $this->_prod_estado = $_prod_estado;
    }

    function get_prod_marca() {
        return $this->_prod_marca;
    }

    function set_prod_marca($_prod_marca) {
        $this->_prod_marca = $_prod_marca;
    }


    
}