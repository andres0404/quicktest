<?php
include_once '../config/class.conexion.php';

class DAOGeneral {
    
    protected $_sql_errno;
    protected $_sql_error;
    protected $_sql_query;
    protected $_sql_total_registros;


    protected $_ordenar;

    /**
     * si la consulta arroja un resultado devuelve resultado, true: en array (como si hubiera mas de un resultado), false[default]: misma clase que consulta
     * @var type 
     */
    private $_1resultadoEnArray = false;
    /**
     * Limit de la consulta (int 1, int 2)
     * @var array
     */
    private $_limit = false; 

    public function __construct() {
       
    }
    /**
     * Establecer limiites para la consulta
     * @param type $val1
     * @param type $val2
     */
    public function setLimit($val1, $val2 = null){
        $this->_limit[0] = $val1;
        if(!empty($val2)){
            $this->_limit[1] = $val2;
        }
    }
    
    /**
     * 
     */
    public function habilita1ResultadoEnArray(){
        $this->_1resultadoEnArray = true;
    }
    /**
     * 
     */
    public function deshabilita1ResultadoEnArray(){
        $this->_1resultadoEnArray = false;
    }
    
    
    /**
     * Obtner el mapa de las clases DAO
     * @return array
     */
    public function getMapa(){
        return $this->_mapa;
    }
    /**
     * Nombre de la tabla en base de datos
     * @return string
     */
    public function getTabla(){
        return $this->_tabla;
    }
    
    function get_sql_errno() {
        return $this->_sql_errno;
    }

    function get_sql_error() {
        return $this->_sql_error;
    }
    function get_sql_query() {
        return $this->_sql_query;
    }
    
    function get_sql_total_registros() {
        return $this->_sql_total_registros;
    }

    
    function set_ordenar($_ordenar) {
        $this->_ordenar = $_ordenar;
    }
    

    
    
    
        /**
     * Obtener primario
     * @return string
     */
    public function getPrimary(){
        return $this->_primario;
    }
    public function getPrimaryValue() {
        return $this->{'_' . $this->_primario};
    }
    /**
     * Establecer un valor al parametro llave primario
     * @param type $value
     */
    public function setPrimaryValue($value) {
        $this->{'_' . $this->_primario} = $value;
    }
    /**
     * 
     * @return integer
     */
    public function eliminar(){
        $con = \Conmain\ConexionSQL::getInstance();
        $where = [];
        if(!empty($this->{'_'.$this->_primario})){
            if(is_array($this->{'_'.$this->_primario})){
                $where[] = ($this->_primario . " IN ('" . implode(",",$this->{'_'.$this->_primario} )."') ");
            }else{
                $where[] = ($this->_primario . " = " . $this->{'_'.$this->_primario});
            }
        }else{
            foreach($this->_mapa as $nom_campo => $arrAtributos){ 
                if ($this->{'_' . $nom_campo} !== null && $nom_campo != $this->_primario && !isset($arrAtributos['sql'])) {
                    if(is_array($this->{'_'.$nom_campo})){
                        $where[] = $nom_campo . " IN ('". implode(",", $this->{'_'.$nom_campo})."') ";
                    }else{
                        $where[] = $nom_campo . " = '" . addslashes($this->{'_' . $nom_campo} ). "'";
                    }
                }
            }
        }
        $query = "DELETE FROM `{$this->_tabla}` WHERE " . implode(" AND ", $where);
        $this->_sql_query = $query;
        if(! $con->guardar($query)){
            $objPDO = $con->get_ObjPDO();
            $this->_sql_errno = $objPDO->errorCode();
            $this->_sql_error = $objPDO->errorInfo()[2];
            return false;
        }
        return true;
    }

    /**
     * 
     * @return boolean
     */
    public function guardar(){
        $con = \Conmain\ConexionSQL::getInstance();
        $set = array();
        //for ($i = 0; $i < count($this->_mapa); $i++) {
        foreach($this->_mapa as $nom_campo => $arrAtributos){    
            if ($this->{'_' . $nom_campo} !== NULL AND $nom_campo != $this->_primario && !isset($arrAtributos['sql'])) {
                $set[] = $nom_campo . " = '" . addslashes($this->{'_' . $nom_campo} ). "'";
            }
        }
        $where = "";
        if(!empty($this->{'_'.$this->_primario})){
            $where = " WHERE $this->_primario = ". $this->{'_'.$this->_primario} ;
            $query = "update `".$this->_tabla."` set ".implode(",", $set) . $where;
        }else{
            $query = "insert into `".$this->_tabla."` set ".  implode(",", $set) ;
        }
      
        if( $con->guardar($query) !== false){
            if(empty($this->{'_'.$this->_primario})){
                $this->{'_'.$this->_primario} = $con->getUltimoIdInsertado();//mysqli_insert_id();
            }
            return true;
        }
        $objPDO = $con->get_ObjPDO();
        $this->_sql_query = $query;
        $this->_sql_errno = $objPDO->errorCode();
        //print_r($objPDO->errorInfo());
        $this->_sql_error = $objPDO->errorInfo()[2];
        return false;
    }
    /**
     * 
     * @return boolean|\clases_llamada
     */
    public function consultar() {
        $where = array();
        $select = array();
        //for ($i = 0; $i < count($this->_mapa); $i++) {
        foreach($this->_mapa as $nom_campo => $arrAtributos){
            if ($this->{'_' . $nom_campo} !== null) {
                if($arrAtributos['tipodato'] == 'date' && is_array($this->{'_' . $nom_campo}) && count($this->{'_' . $nom_campo}) == 2){
                    $where[] = $nom_campo . " BETWEEN '".$this->{'_' . $nom_campo}[0] ."' AND '".$this->{'_' . $nom_campo}[1]."' ";
                }else{
                    $where[] = $nom_campo . " = '" . $this->{'_' . $nom_campo} . "'";
                }
            }
            if(isset($arrAtributos['sql']) && !empty($arrAtributos['sql'])){
                $select[] = $arrAtributos['sql'] . " as " . $nom_campo;
            }else{
                $select[] = $nom_campo;
            }
        }
        
        if (count($where) == 0) {
            $query = "select ".implode(",",$select)." from `" . $this->_tabla . "` where 1 ";
        } else {
            $query = "select ".implode(",",$select)." from `" . $this->_tabla . "` where " . implode(" AND ", $where)." ";
        }
        // orden 
        if(isset($this->_ordenar) && is_array($this->_ordenar) && count($this->_ordenar) > 0){
            $query .= ( " ORDER BY ".implode(",",  $this->_ordenar));
        }
        // limites
        if(!empty($this->_limit)){
            $query .= (" LIMIT " . implode(",", $this->_limit));
        }
        //echo $query;die();
        $con = \Conmain\ConexionSQL::getInstance();
        $id = $con->consultar($query);
        //echo "consultado: $nummm -- ";
        //echo $con->getNumeroFilasConsultadas($id);
        if($res = $con->obtenerFila($id)){ 
            $this->_sql_total_registros = $con->get_total_registros(); 
            if ($con->get_total_registros() == 1 && !$this->_1resultadoEnArray) {// si viene mas de un resultado debe clonarse la clase y retornar en un arreglo de clases
                //$res = $con->obenerFila($id);
                //for ($i = 0; $i < count($this->_mapa); $i++) {
                foreach($this->_mapa as $nom_campo => $arrAtributos){
                    $this->{'_' . $nom_campo} = $res[$nom_campo];
                }
                
                return true;
            } else {
                $R = array();
                do{
                    $clases_llamada = get_called_class();
                    $obj = new $clases_llamada()  ;
                    //print_r($this->_mapa);
                    foreach($this->_mapa as $nom_campo => $arrAtributos){
                        //print_r($arrAtributos);
                        //echo "$nom_campo : $res[$nom_campo] ";
                        //$obj->{'_' . $this->_mapa[$i]} = $res[$this->_mapa[$i]];
                        $obj->{'set_'.$nom_campo}($res[$nom_campo]);
                    }
                    //print_r($obj);
                    $R[] = $obj;
                }while($res = $con->obtenerFila($id));
                return $R;
            }
        }
        return false;
    }
    /**
     * Obtener los elementos de la clase en formato array
     * @return string [json]
     */
    public function getArray() {
        $json = [];
        foreach($this->_mapa as $key => $atribute){
            $json[$key] = $this->{"_".$key};
        }
        return $json;
    }

}
class DAOException extends Exception{}
