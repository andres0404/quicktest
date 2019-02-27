<?php

include_once 'class.DAO.php'; 

class DAO_Facturas extends DAOGeneral {


    protected $_fac_id;
    protected $_cli_id;
    protected $_fac_total;
    protected $_fac_fecha_generacion;
    protected $_fac_fecha_vence;
    protected $_fac_estado;
    protected $_strEstado;
    protected $_DAO_Factura_items_lista;


    protected $_tabla = 'facturas';
    
    protected $_mapa = [
        'fac_id' => ['tipodato' => 'varchar'],
        'cli_id' => ['tipodato' => 'varchar'],
        'fac_total' => ['tipodato' => 'varchar'],
        'fac_fecha_generacion' => ['tipodato' => 'varchar'],
        'fac_fecha_vence' => ['tipodato' => 'varchar'],
        'fac_estado' => ['tipodato' => 'varchar'],
        'strEstado' => ['tipodato' => 'varchar', 'sql' => '(SELECT valor FROM m_contenido WHERE mtabla_id = 1 AND nombre = fac_estado)']
    ];
    protected $_primario = 'fac_id';
    
    function get_fac_id() {
        return $this->_fac_id;
    }

    function get_cli_id() {
        return $this->_cli_id;
    }

    function get_fac_total() {
        return $this->_fac_total;
    }

    function get_fac_fecha_generacion() {
        return $this->_fac_fecha_generacion;
    }

    function get_fac_fecha_vence() {
        return $this->_fac_fecha_vence;
    }

    function get_strEstado() {
        return $this->_strEstado;
    }

    function set_fac_id($_fac_id) {
        $this->_fac_id = $_fac_id;
    }

    function set_cli_id($_cli_id) {
        $this->_cli_id = $_cli_id;
    }

    function set_fac_total($_fac_total) {
        $this->_fac_total = $_fac_total;
    }

    function set_fac_fecha_generacion($_fac_fecha_generacion) {
        $this->_fac_fecha_generacion = $_fac_fecha_generacion;
    }

    function set_fac_fecha_vence($_fac_fecha_vence) {
        $this->_fac_fecha_vence = $_fac_fecha_vence;
    }

    function set_strEstado($_strEstado) {
        $this->_strEstado = $_strEstado;
    }

    function get_fac_estado() {
        return $this->_fac_estado;
    }

    function get_DAO_Factura_items_lista() {
        return $this->_DAO_Factura_items_lista;
    }

    function set_fac_estado($_fac_estado) {
        $this->_fac_estado = $_fac_estado;
    }

    function set_DAO_Factura_items_lista($_DAO_Factura_items_lista) {
        $this->_DAO_Factura_items_lista = $_DAO_Factura_items_lista;
    }
    /**
     * 
     * @return DAO_Facturas
     * @throws DAOException
     */
    function actualizar_total(){
        $query = "UPDATE facturas fc SET fac_total = 
(SELECT SUM(itm_cantidad*(SELECT prod_precio FROM productos pr WHERE pr.prod_id = itm.prod_id)) tot_fac FROM factura_items itm WHERE itm.fac_id = fc.fac_id)
WHERE fc.fac_id = {$this->_fac_id}";
        $con = \Conmain\ConexionSQL::getInstance();
        if(!$con->consultar($query)){
            throw new DAOException("Error al actualizar total de la factura ".$con->get_ObjPDO()->errorCode());
        }
        
        return true;
    }


    
}
