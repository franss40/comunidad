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
    /**
     * Adiciona un usuario
     * 
     * @param array $usuario
     * @return boolean
     */
    public function addUsuario($usuario) {
        $sql = "INSERT INTO login(email_usuario, usuario, password  , activo, tipo) 
                    VALUES(:email, :usuario, :password, :activo, :tipoUsuario)";

        $hash= password_hash($usuario->password, PASSWORD_DEFAULT);
        $usuario->activo = ($usuario->activo) ? true : false;
        
        $this->db->prepared($sql);
        $this->db->bind('email', $usuario->email, 'string');
        $this->db->bind('usuario', $usuario->usuario, 'string');
        $this->db->bind('password', $hash, 'string');
        $this->db->bind('activo', $usuario->activo, 'string');
        $this->db->bind('tipoUsuario', $usuario->tipoUsuario, 'string');

        return $this->db->noResultPrepared();
    }
}
