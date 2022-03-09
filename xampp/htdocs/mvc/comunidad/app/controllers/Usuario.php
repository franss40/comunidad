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
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRIPPED);
        $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRIPPED);
        $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRIPPED);
        $activo = filter_input(INPUT_POST, 'activo', FILTER_SANITIZE_STRIPPED);
        $tipoUsuario = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRIPPED);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRIPPED);
        
        // Si los datos son correctos y no están vacios...
        if (!empty($email) && !empty($usuario) && !empty($password) && $token == $_SESSION['token']) {
            $tipoPermitido = array('ADMIN', 'OPERARIO', 'USUARIO');
            $activoPermitido = array('SI', 'NO');
            if (!in_array($tipoUsuario, $tipoPermitido) || !in_array($activo, $activoPermitido)) {  
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
                $this->render('comunidad/nuevoUsuario_view', $data);
                return;
            }
            
            $user = new stdClass();
            $user->email = $email; 
            $user->usuario = $usuario;
            $user->password = $password;
            $user->activo = $activo;
            $user->tipoUsuario = $tipoUsuario;
            
            if ($this->model->addUsuario($user)) {
                $data['info'] = 'Registro añadido correctamente';
            } else {
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
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
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRIPPED);
        $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRIPPED);
        $activo = filter_input(INPUT_POST, 'activo', FILTER_SANITIZE_STRIPPED);
        $tipoUsuario = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRIPPED);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRIPPED);
        
        // Si los datos son correctos y no están vacios...
        if (!empty($email) && !empty($password) && $token == $_SESSION['token']) {
            $tipoPermitido = array('ADMIN', 'OPERARIO', 'USUARIO');
            $activoPermitido = array('SI', 'NO');
            if (!in_array($tipoUsuario, $tipoPermitido) || !in_array($activo, $activoPermitido)) {  
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
                $this->render('comunidad/editarUsuario_view', $data);
                return;
            }
            
            $user = new stdClass();
            $user->email = $email; 
            $user->usuario = $usuario;
            $user->password = $password;
            $user->activo = $activo;
            $user->tipoUsuario = $tipoUsuario;
            
            if ($this->model->editUsuario($user)) {
                $data['info'] = 'Registro editado correctamente';
            } else {
                $data['info'] = 'Se ha producido un error. Pruebe más tarde';
            }
        }
        
        
        $user = $this->model->getUsuario($usuario);
        $data['usuario'] = $user;
        $this->render('usuario/editarUsuario_view', $data);
    }
    
    /**
     * Borramos un Usuario
     * 
     * @param string $usuario
     */
    public function borrar($usuario) {
        $data = ['info' => 'Se ha producido un error al intentar borrar la comunidad'];
        if ($this->model->borrarUsuario($usuario)) {
            $data = ['result' => 'Usuario borrado',
                     'info' => 'Borrado Usuario'];
        }
        $this->render('informacion_view', $data);
    }
}
