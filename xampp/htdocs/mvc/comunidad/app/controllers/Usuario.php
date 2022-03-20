<?php
/**
 * Gestión de usuarios
 *
 * @author Fco Sanz
 */
class Usuario extends Controller {
    
    public function __construct() {
        $this->setModel('Usuarios');
    }
    /**
     * Controlador que muestra los usuarios
     */
    public function index() {
        $usuarios = $this->model->getUsuarios();
        $total = $this->model->getTotal();
        $data = ['usuarios' => $usuarios, 'total' => $total];
        $this->render('usuario/usuario_view', $data);
    }
    /**
     * Añadimos un nuevo usuario
     */
    public function nuevo() {
        $data = ['info' => 'Alta Usuario',
            'token' => $_SESSION['token']
        ];
        
        // recupero datos enviados mediante post de manera segura
        $filtroPost = $this->filtrarPost();

        // Si los datos son correctos y no están vacios...
        if (!empty($filtroPost->email_usuario) && !empty($filtroPost->usuario) && !empty($filtroPost->password) && $filtroPost->token == $_SESSION['token']) {
            $tipoPermitido = array('ADMIN', 'OPERARIO', 'USUARIO');
            $activoPermitido = array('SI', 'NO');
            if (!in_array($filtroPost->tipo, $tipoPermitido) || !in_array($filtroPost->activo, $activoPermitido)) {  
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
                $this->render('comunidad/nuevoUsuario_view', $data);
            }

            $data['info'] = 'Se ha producido un error. Pruebe más tarde';
            if ($this->model->addUsuario($filtroPost)) {
                $data['info'] = 'Registro añadido correctamente';
            }
        }
        
        $this->render('usuario/nuevoUsuario_view', $data);
    }
    /**
     * Editamos un Usuario
     * 
     * @param string $usuario
     */
    public function editar($usuario) {
        require_once APPROOT . '/views/helpers_view.php';
        
        $data = ['info' => 'Editar Usuario',
            'token' => $_SESSION['token']
        ];
        
        // recupero datos enviados mediante post de manera segura
        $filtroPost = $this->filtrarPost();

        // Si los datos son correctos y no están vacios...
        if (!empty($filtroPost->email_usuario) && !empty($filtroPost->password) && $filtroPost->token == $_SESSION['token']) {
            $tipoPermitido = array('ADMIN', 'OPERARIO', 'USUARIO');
            $activoPermitido = array('SI', 'NO');
            if (!in_array($filtroPost->tipo, $tipoPermitido) || !in_array($filtroPost->activo, $activoPermitido)) {  
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
                $this->render('comunidad/editarUsuario_view', $data);
            }
            
            $data['info'] = 'Se ha producido un error. Pruebe más tarde';
            if ($this->model->editUsuario($filtroPost)) {
                $data['info'] = 'Registro editado correctamente';
            }
        }

        $user = $this->model->getUsuario($usuario);
        $data['usuario'] = $user;
        $this->render('usuario/editarUsuario_view', $data);
    }
    
    /**
     * Filtrar datos del usuario. Retorno null si no hay datos post
     * 
     * @return array
     */
    private function filtrarPost() {
        
        $activo = filter_input(INPUT_POST, 'activo', FILTER_SANITIZE_STRIPPED);
        $email_usuario = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRIPPED);
        $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRIPPED);
        $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRIPPED);
        $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRIPPED);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRIPPED);
        
        $login = new stdClass();
        $login->activo = $activo; 
        $login->email_usuario = $email_usuario;
        $login->usuario = $usuario;
        $login->password = $password; 
        $login->tipo = $tipo;
        $login->token = $token;
        
        if (empty($usuario) || empty($email_usuario) || empty($tipo)) {
            $login = null;
        }
        return $login;
    }
    
    /**
     * Borramos un Usuario
     * 
     * @param string $usuario
     */
    public function borrar($usuario) {
        $data = ['info' => 'Se ha producido un error al intentar borrar el usuario'];
        if ($this->model->borrarUsuario($usuario)) {
            $data = ['result' => 'Usuario borrado',
                     'info' => 'Borrado Usuario'];
        }
        $this->render('informacion_view', $data);
    }
}
