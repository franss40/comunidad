<?php

/**
 * Modelo del Login de usuarios
 *
 * @author Fco Sanz
 */
class Logins {

    private $db;

    /**
     * Cargamos la base de datos para poder acceder a ella
     */
    public function __construct() {
        $this->db = new DataBase();
    }

    /**
     * Comprobación si el usuario y la contraseña introducida es correcta
     * 
     * Se usa la función nativa de PHP password_hash para crear el hash
     * y password_verify para verificarlo:
     * $hash= password_hash("admin", PASSWORD_DEFAULT);
     * password_verify('contraseña', $hash)
     * 
     * @param string $user
     * @param string $pass
     * @return boolean
     */
    public function verifyPass($user, $pass) {

        $sql = "SELECT * FROM Login WHERE usuario = '$user'";
        $usuario = $this->db->result($sql);

        if ($usuario) {
            if (password_verify($pass, $usuario[0]->password)) {
                return $usuario;
            }
        }
        return false;
    }

}
