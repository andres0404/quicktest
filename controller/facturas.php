<?php

include_once 'controller.php';
include_once("../model/DAO_Facturas.php");
include_once("../model/DAO_Factura_items.php");

class Facturas extends Controller {

    function __construct() {
        
    }

    /**
     * 
     * @return \self
     */
    public static function run() {
        return new self();
    }

    /**
     * Listar todos los elementos de la tabla customers
     * @return type
     * @throws DAOException
     */
    public function listarFacturas($fac_id = null) {
        $objFacturas = new DAO_Facturas();
        if (!empty($fac_id)) {
            $objFacturas->set_fac_id($fac_id);
        }
        $arrFact = $this->_listar($objFacturas);
        if (is_array($arrFact) && count($arrFact)) {
            for ($i = 0; $i < count($arrFact); $i++) {
                $_objFacItm = new DAO_Factura_items();
                $_objFacItm->set_fac_id($arrFact[$i]['fac_id']);
                $arrFact[$i]['items'][] = $this->_listar($_objFacItm,false);
            }
        }
        return $arrFact;
    }

    /**
     * 
     * @param type $id
     */
    public function eliminarFactura($id) {
        $_objFActura = new DAO_Facturas();
        $_objFActura->set_fac_id($id);
        $this->_eliminarRegistro($_objFActura);
    }
    
    public function eliminarItem($fac_id, $facitm_id) {
        if(!$this->existeFactura($fac_id)){
            throw new DAOException("No existe factura");
        }
        $_objFacItm = new DAO_Factura_items();
        $_objFacItm->set_facitm_id($facitm_id);
        if(!$_objFacItm->eliminar()){
            throw new DAOException("No se pudo eliminar item de la factura " . $_objFacItm->get_sql_query());
        }
        return true;
    }
    
    public function existeFactura($id) {
        return $this->_existeID(new DAO_Facturas(), $id);
    }

}
