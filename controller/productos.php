<?php
include_once 'controller.php';
include_once("../model/DAO_Productos.php");
class Productos extends Controller {

    function __construct() {
        
    }
    /**
     * 
     * @return \self
     */
    public static function run(){
        return new self();
    }
    /**
     * Listar todos los elementos de la tabla customers
     * @return type
     * @throws DAOException
     */
    public function listarProductos($pro_id = null){
        $objPorductos = new DAO_Productos();
        if(!empty($pro_id)){
            $objPorductos->set_prod_id($pro_id);
        }
        return $this->_listar($objPorductos);
    }
    /**
     * 
     * @param type $id
     */
    public function eliminarProducto($id){
        $_objProductos = new DAO_Productos();
        $_objProductos->set_prod_id($id);
        $this->_eliminarRegistro($_objProductos);
    }
    
    
    
}

