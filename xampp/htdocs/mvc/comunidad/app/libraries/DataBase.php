<?php

/**
 * Uso de PDO para facilitar las cosas para recuperar datos
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

    function result($sql) {
        try {
            // protege contra inyecciones sql
            $this->stmt = $this->dbh->quote($sql);
            $this->stmt = $this->dbh->query($sql);
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $exc) {
            echo 'error: ' . $exc->getTraceAsString();
        }
    }

    // Aquí preparamos parámetros (:nombreParametro)
    // Agregamos seguidamente los parámetros con bind
    // para seguidamente ejecutar la sentencia con resultPrepared
    function prepared($sql) {
        try {
            $this->stmt = $this->dbh->prepare($sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    // Type solo puede ser: null, int, bool, string
    // Si no lo pongo cogemos el tipo de datos que pasamos por parámetro
    function bind($param, $value, $type = null) {
        $permitido = array('int', 'bool', 'string', null);
        if (!in_array($type, $permitido)) {
            die('Datos no permitidos');
        }
        if ($type == null) {
            $type = gettype($value);
        }
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

    function resultPrepared() {
        try {
            $this->stmt->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    function rowCount() {
        return $this->stmt->rowCount();
    }

    function lastID() {
        return $this->dbh->lastInsertId();
    }

}
