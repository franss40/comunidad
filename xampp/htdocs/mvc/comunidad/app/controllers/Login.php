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
        $salida = '';
        $usuario = filter_input(INPUT_POST, 'usuario');
        if (isset($usuario)) {
            $salida = $usuario;
        }
        $data = array('nombre' => $salida);
        $this->render('login_view', $data);
    }

}
