<?php

/**
 * Clase que comprueba el acceso de los usuarios
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
     * Se comprueba si está autorizado el usuario o no antes de acceder 
     * 
     */
    public function index() {

        $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRIPPED);
        $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRIPPED);

        $data = array('info' => 'Por favor ingrese sus credenciales para acceder');

        if (!empty($usuario) && !empty($pass)) {
            $usuario_verify = $this->model->verifyPass($usuario, $pass);
            if ($usuario_verify && $usuario_verify[0]->activo) {
                $_SESSION['user'] = $usuario_verify[0]->usuario;
                $_SESSION['tipo'] = $usuario_verify[0]->tipo;
                redirect(comunidad);
            } else {
                $data = array('info' => 'Usuario o contraseña incorrectos');
            }
        }
        $this->render('login_view', $data);
    }

}
