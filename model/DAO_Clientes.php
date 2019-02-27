<?php
include_once 'class.DAO.php'; 

class DAO_Clientes extends DAOGeneral {

    protected $_cli_id;
    protected $_cli_nombre;
    protected $_cli_email;
    protected $_cli_documento;
    protected $_cli_estado;


    protected $_tabla = 'clientes';
    protected $_mapa = [
        'cli_id' => ['tipodato' => 'varchar'],
        'cli_nombre' => ['tipodato' => 'varchar'],
        'cli_email' => ['tipodato' => 'varchar'],
        'cli_documento' => ['tipodato' => 'varchar'],
        'cli_estado' => ['tipodato' => 'varchar'],
    ];
    protected $_primario = 'cli_id';

    function get_cli_id() {
        return $this->_cli_id;
    }

    function get_cli_nombre() {
        return $this->_cli_nombre;
    }

    function get_cli_email() {
        return $this->_cli_email;
    }

    function get_cli_documento() {
        return $this->_cli_documento;
    }

    function get_cli_estado() {
        return $this->_cli_estado;
    }

    function set_cli_id($_cli_id) {
        $this->_cli_id = $_cli_id;
    }

    function set_cli_nombre($_cli_nombre) {
        $this->_cli_nombre = $_cli_nombre;
    }

    function set_cli_email($_cli_email) {
        $this->_cli_email = $_cli_email;
    }

    function set_cli_documento($_cli_documento) {
        $this->_cli_documento = $_cli_documento;
    }

    function set_cli_estado($_cli_estado) {
        $this->_cli_estado = $_cli_estado;
    }


    
}