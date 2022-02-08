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
        $nombre = filter_input(INPUT_POST, 'nombre');
        if (isset($nombre)) {
            $salida = 'hola';
        }
        $data = array('nombre' => $salida);
        $this->render('login_view', $data);
    }

}
