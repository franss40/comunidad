<?php

/**
 * Modelo del Login de usuarios
 *
 * @author Fco Sanz
 */
class Logins {

    private $db;

    public function __construct() {
        $this->db = new DataBase();
    }

    public function verifyPass($user, $pass) {
        /*         * *************
          $hash= password_hash("admin", PASSWORD_DEFAULT);

          if (password_verify('contraseña', $hash)) {
          echo '¡La contraseña es válida!';
          } else {
          echo 'La contraseña no es válida.';
          }
         * ********** */


        $sql = "SELECT * FROM Login WHERE usuario = '$user'";
        $usuario = $this->db->result($sql);

        if ($usuario) {
            if (password_verify($pass, $usuario[0]->password)) {
                return true;
            }
        }

        return false;
    }

}
