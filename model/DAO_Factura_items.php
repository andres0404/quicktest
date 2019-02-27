<?php

include_once 'class.DAO.php'; 

class DAO_Factura_items extends DAOGeneral {

    protected $_facitm_id;
    protected $_fac_id;
    protected $_prod_id;
    protected $_itm_cantidad;
    protected $_itm_total;
    
    
    protected $_tabla = 'factura_items';
    
    protected $_mapa = [
        'facitm_id' => ['tipodato' => 'integer'],
        'fac_id' => ['tipodato' => 'varchar'],
        'prod_id' => ['tipodato' => 'varchar'],
        'itm_cantidad' => ['tipodato' => 'varchar'],
        'itm_total' => ['tipodato' => 'varchar'],
        
    ];
    protected $_primario = 'facitm_id';
    
    function get_facitm_id() {
        return $this->_facitm_id;
    }

    function get_fac_id() {
        return $this->_fac_id;
    }

    function get_prod_id() {
        return $this->_prod_id;
    }

    function get_itm_cantidad() {
        return $this->_itm_cantidad;
    }

    function get_itm_total() {
        return $this->_itm_total;
    }

    function set_facitm_id($_facitm_id) {
        $this->_facitm_id = $_facitm_id;
    }

    function set_fac_id($_fac_id) {
        $this->_fac_id = $_fac_id;
    }

    function set_prod_id($_prod_id) {
        $this->_prod_id = $_prod_id;
    }

    function set_itm_cantidad($_itm_cantidad) {
        $this->_itm_cantidad = $_itm_cantidad;
    }

    function set_itm_total($_itm_total) {
        $this->_itm_total = $_itm_total;
    }



}