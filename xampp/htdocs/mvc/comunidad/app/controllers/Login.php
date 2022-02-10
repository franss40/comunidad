<?php

/**
 * Clase que da acceso a los usuarios
 *
 * @author Fco Sanz
 */
class Login extends Controller {
    /**
     * Cargamos el modelo del Logins
     */
    public function __construct() {
        $this->setModel('Logins');
    }

    /**
     * Se comprueba si está autorizado el usuario o no antes de entrar 
     * en la aplicación.
     */
    public function index() {

        $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRIPPED);
        $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRIPPED);

        $data = array('info' => 'Por favor ingrese sus credenciales para poder acceder');

        if (!empty($usuario) && !empty($pass)) {
            if ($this->model->verifyPass($usuario, $pass)) {
                redirect(comunidad);
            } else {
                $data = array('info' => 'Usuario o contraseña incorrectos');
            }
        }
        $this->render('login_view', $data);
    }

}
