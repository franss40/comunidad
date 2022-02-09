<?php

/**
 * Da acceso a los usuarios
 *
 * @author Usuario
 */
class Login extends Controller {

    public function __construct() {
        
    }

    public function index() {
        //$usuario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
        $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRIPPED);
        $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRIPPED);

        if ($usuario === null || $pass === null) {
            $this->render('login_view');
            return;
        }

        if (!empty($usuario) && !empty($pass)) {
            $data = array('info' => 'Acceso concedido');
        } else {
            $data = array('info' => 'Usuario o contraseña incorrectos');
        }
        $this->render('login_view', $data);
    }

}
