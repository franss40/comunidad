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
        $info = '';
        $usuario = filter_input(INPUT_POST, 'usuario');
        if (isset($usuario)) {
            $info = $usuario;
        }
        $data = array('info' => $info);
        $this->render('login_view', $data);
    }

}
