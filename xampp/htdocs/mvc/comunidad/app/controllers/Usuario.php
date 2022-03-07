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

    public function index() {
        $usuarios = $this->model->getUsuarios();
        $total = $this->model->getTotal();
        $data = ['usuarios' => $usuarios, 'total' => $total];
        $this->render('usuario/usuario_view', $data);
    }
}
