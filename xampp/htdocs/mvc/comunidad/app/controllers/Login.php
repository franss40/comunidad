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
        // Nota: Stripped es un alias de STRING
        // Creamos un token para mayor seguridad

        if (!$_SESSION['token']) {
            $_SESSION['token'] = md5(mt_rand(1, 10000000));
        }

        $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRIPPED);
        $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRIPPED);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRIPPED);

        $data = array('info' => 'Por favor ingrese sus credenciales para acceder',
            'token' => $_SESSION['token']);

        if (!empty($usuario) && !empty($pass) && $token == $_SESSION['token']) {
            $usuario_verify = $this->model->verifyPass($usuario, $pass);
            if ($usuario_verify && $usuario_verify[0]->activo) {
                $_SESSION['user'] = $usuario_verify[0]->usuario;
                $_SESSION['tipo'] = $usuario_verify[0]->tipo;
                redirect(comunidad);
            } else {
                $data = array('info' => 'Usuario o contraseña incorrectos',
                    'token' => $_SESSION['token']);
            }
        }
        $this->render('login_view', $data);
    }

}
