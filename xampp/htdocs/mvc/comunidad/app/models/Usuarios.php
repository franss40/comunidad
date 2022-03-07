<?php
/**
 * Modelo de Usuarios
 *
 * @author Fco Sanz
 */
class Usuarios {
    
    private $db;

    public function __construct() {
        $this->db = new DataBase();
    }
    
    /**
     * Retorna los usuarios existentes
     * 
     * @return array
     */
    public function getUsuarios() {
        $sql = "SELECT * FROM login ORDER BY email_usuario";
        return $this->db->result($sql);
    }
    
    /**
     * Retorna el número total de registros
     * 
     * @return int
     */
    public function getTotal() {
        return $this->db->rowCount();
    }
}
