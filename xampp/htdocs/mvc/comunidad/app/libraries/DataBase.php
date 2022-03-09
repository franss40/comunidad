<?php

/**
 * Uso de PDO para más facilidad para recuperar datos
 * 
 * La consulta normal sería (también escapa datos, pero de otra forma)
 * $this->db->result($sql);
 * Consulta con datos escapados sería:    
 * $this->db->prepared("select * from codigos where Poblacion=:ciudad");   
 * $this->db->bind(':ciudad', 'Madrid'); 
 * return $this->db->resultPrepared();        
 *
 * @author Fran
 */
class DataBase {

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $dbh;
    private $stmt;

    /**
     * Conectamos a la BBDD
     */
    public function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname}";

        $options = array(PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (Exception $exc) {
            echo 'error: ' . $exc->getMessage();
        }
    }

    /**
     * Obtiene el resultado sin preparar los datos antes
     * 
     * @param string $sql
     * @return array
     */
    function result($sql) {
        try {
            // Se puede utilizar también $this->dbh->quote($sql) para proteger contra inyecciones sql
            $this->stmt = $this->dbh->query($sql);
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $exc) {
            echo 'error: ' . $exc->getTraceAsString();
        }
    }

    /**
     * Preparamos el sql para escapar los datos
     * Aquí preparamos parámetros (:nombreParametro)
     * Agregamos seguidamente los parámetros con bind
     * para seguidamente ejecutar la sentencia con resultPrepared
     * 
     * @param string $sql
     */
    function prepared($sql) {
        try {
            $this->stmt = $this->dbh->prepare($sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * Escapa valores introducidos en el sql con prepared
     * 
     * @param type $param
     * @param type $value
     * @param type $type
     */
    function bind($param, $value, $type = null) {
        switch ($type) {
            case 'int':
                $type = PDO::PARAM_INT;
                break;
            case 'bool':
                $type = PDO::PARAM_BOOL;
                break;
            case 'string':
                $type = PDO::PARAM_STR;
                break;
            default:
                $type = PDO::PARAM_STR;
                break;
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    /**
     * Devuelve el resultado de la consulta después de prepared y bind
     * 
     * @return array
     */
    function resultPrepared() {
        try {
            $this->stmt->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $exc) {
            echo $exc->getMessage().'<br>'.$exc->getTraceAsString();
        }
    }
    /**
     * Devuelve un resultado de la consulta después de prepared y bind
     * 
     * @return array
     */
    function resultPreparedOne() {
        try {
            $this->stmt->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $exc) {
            echo $exc->getMessage().'<br>'.$exc->getTraceAsString();
        }
    }
    
    /**
     * Después de prepared y bind cuando se insertan o actualizan datos
     * 
     * @return boolean
     */
    function noResultPrepared() {
        try {
            return $this->stmt->execute();
        } catch (Exception $exc) {
            echo $exc->getMessage().'<br>'.$exc->getTraceAsString();
        }
    }


    /**
     * Devuelve el número de filas
     * 
     * @return int
     */
    function rowCount() {
        return $this->stmt->rowCount();
    }

    /**
     * Devuelve la última Id insertada
     * 
     * @return int
     */
    function lastID() {
        return $this->dbh->lastInsertId();
    }
    /**
     * Destruye la conexión
     */
    public function __destruct() {
        $this->dbh = '';
        $this->stmt = '';
    }
}
