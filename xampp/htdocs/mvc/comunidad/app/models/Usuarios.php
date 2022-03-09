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
     * Retorna el Usuario según el nombre de usuario pasado
     * 
     * @param string $usuario
     * @return array
     */
    public function getUsuario($usuario) {
        $sql = "SELECT * FROM login WHERE usuario = :user";
        $this->db->prepared($sql);
        $this->db->bind('user', $usuario, 'string');
        return $this->db->resultPreparedOne();
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
        if ($usuario->activo == 'SI') {
            $usuario->activo = true;
        } else {
            $usuario->activo = false;
        }
        
        $this->db->prepared($sql);
        $this->db->bind('email', $usuario->email, 'string');
        $this->db->bind('usuario', $usuario->usuario, 'string');
        $this->db->bind('password', $hash, 'string');
        $this->db->bind('activo', $usuario->activo, 'bool');
        $this->db->bind('tipoUsuario', $usuario->tipoUsuario, 'string');

        return $this->db->noResultPrepared();
    }
    
    /**
     * Editamos un Usuario
     * 
     * @param string $user
     * @return boolean
     */
    public function editUsuario($user) {
        $sql = "UPDATE login SET email_usuario=:email, password=:password, activo=:activo, tipo=:tipo WHERE usuario=:usuario";
        
        $hash= password_hash($user->password, PASSWORD_DEFAULT);
        if ($user->activo == 'SI') {
            $user->activo = true;
        } else {
            $user->activo = false;
        }
        
        $this->db->prepared($sql);
        $this->db->bind('email', $user->email, 'string');
        $this->db->bind('password', $hash, 'string');
        $this->db->bind('activo', $user->activo, 'bool');
        $this->db->bind('tipo', $user->tipoUsuario, 'string');
        $this->db->bind('usuario', $user->usuario, 'string');
        return $this->db->noResultPrepared();
    }
    
    /**
     * Borramos una comunidad
     * 
     * @param string $usuario
     * @return boolean
     */
    public function borrarUsuario($usuario) {
        $sql = "DELETE FROM login WHERE usuario = :usuario";
        $this->db->prepared($sql);
        $this->db->bind('usuario', $usuario, 'string');
        return $this->db->noResultPrepared();
    }
}
