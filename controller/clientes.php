<?php
include_once 'controller.php';
include_once("../model/DAO_Clientes.php");
class Clientes extends Controller{

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
    public function listarClientes($cli_id = null){
        $objClientes = new DAO_Clientes();
        if(!empty($cli_id)){
            $objClientes->set_cli_id($cli_id);
        }
        return $this->_listar($objClientes);
    }
    
    public function eliminarCliente($id){
        $_objClientes = new DAO_Clientes();
        $_objClientes->set_cli_id($id);
        $this->_eliminarRegistro($_objClientes);
    }
    
    
}


