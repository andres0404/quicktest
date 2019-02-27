<?php   

class Controller {
    
    
    /**
     * 
     * @param DAOGeneral $_objDAO
     * @return type
     * @throws DAOException
     */
    protected function _listar(DAOGeneral $_objDAO,$throws = true){
        $_objDAO->habilita1ResultadoEnArray();
        $arrObj = $_objDAO->consultar();
        if(!is_array($arrObj) || count($arrObj) <= 0){
            if($throws)
                throw new DAOException("No se encontraron registros en ".  get_class($_objDAO));
            return "";
        }
        $R = [];
        foreach($arrObj as $objCus){
            if($objCus instanceof DAOGeneral){
                $R[] = $objCus->getArray();
            }
        }
        return $R;
    }
    /**
     * 
     * @param DAOGeneral $_objDAO
     * @throws DAOException
     */
    protected function _eliminarRegistro(DAOGeneral $_objDAO) {
        $id = $_objDAO->getPrimaryValue();
        if(empty($id)){
            throw new DAOException("No se establecio parametro a eliminar ".  get_class($_objDAO));
        }
        if(!$_objDAO->eliminar()){
            throw new DAOException("No se pudo eliminar registro ".get_class($_objDAO)." ".$_objDAO->get_sql_error(). $_objDAO->get_sql_query() );
        }
        return true;
    }
    
    
    protected function _existeID(DAOGeneral $_obj,$id){
        $_obj->setPrimaryValue($id);
        $_obj->consultar();
        if($_obj->get_sql_total_registros() > 0 ){
            return $_obj;
        }
        return false;
    }
}