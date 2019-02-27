<?php

namespace Conmain;

class Conectar {

    private $_conexiones = [
        'default' => [
            'host' => 'beitech-sas.ccnlcdeiv1f1.us-east-1.rds.amazonaws.com',
            'user' => 'beitech_test',
            'pass' => 'K#j~t33@M}',
            'dbname' => 'test'
        ],
        'localhost' => [
            'host' => 'localhost',
            'user' => 'root',
            'pass' => '',
            'dbname' => 'quickf'
        ]
    ];
    private static $_obj = NULL;

    /**
     * 
     * @param type $cx
     * @return \PDO
     * @throws ConexionException
     */
    protected function _conectarBD($cx = "default") {
        try {
            $con = new \PDO("mysql:host={$this->_conexiones[$cx]['host']};dbname={$this->_conexiones[$cx]['dbname']}", $this->_conexiones[$cx]['user'], $this->_conexiones[$cx]['pass']
            );
            return $con;
        } catch (\PDOException $ex) {
            throw new ConexionException($ex->getMessage(), $ex->getCode());
        }
    }

  
}

class ConexionSQL extends Conectar {

    /**
     *
     * @var \PDO
     */
    private $_ObjPDO;
    
    private $_total_registros;
    /**
     *
     * @var integer
     */
    private $_ultimo_id_insertado;
    

    /**
     *
     * @var Conmain\Conexion 
     */
    private static $_obj = NULL;

    function __construct() {
        $this->_ObjPDO = $this->_conectarBD("localhost");
    }
    /**
     * 
     * @return type
     */
    function getUltimoIdInsertado() {
        return $this->_ultimo_id_insertado;
    }
    /**
     * 
     * @return \PDO
     */
    function get_ObjPDO() {
        return $this->_ObjPDO;
    }

    function get_total_registros() {
        return $this->_total_registros;
    }    
    /**
     * Obtener una instancia de la conexion. La crea si no existe, si existe la retorna
     * @return \Conmain\ConexionSQL
     * @throws ConexionException
     */
    public static function getInstance() {
        if (self::$_obj === NULL) {
            self::$_obj = new self();
        }
        return self::$_obj;
    }
    /**
     * Guarda o modifica los elementos establecidos en el DAO
     * Devuelve el numero de registros afectados
     * @param type $query
     * @return integer
     */
    public function guardar($query){
        $regAfect = $this->_ObjPDO->exec($query);
        $this->_ultimo_id_insertado = $this->_ObjPDO->lastInsertId();
        return $regAfect;
    }
    
    public function begin() {
        $this->_ObjPDO->beginTransaction();
    }
    public function commit(){
        $this->_ObjPDO->commit();
    }
    public function rollBack(){
        $this->_ObjPDO->rollBack();
    }

    /**
     * 
     * @param type $query
     * @return \PDOStatement
     * @throws ConexionException
     */
    public function consultar($query) {
        $fetch = $this->_ObjPDO->prepare($query);
        if (!$fetch->execute()) {
            throw new ConexionException($fetch->errorInfo()[2]);
        }
        $this->_total_registros = $fetch->rowCount();
        return $fetch;
    }
    /**
     * 
     * @param PDOStatement $fetch
     * @return array | false
     */
    public function obtenerFila(&$fetch) {
        return $ft = $fetch->fetch(\PDO::FETCH_ASSOC);
    }

}

class ConexionException extends \Exception {
    
}
