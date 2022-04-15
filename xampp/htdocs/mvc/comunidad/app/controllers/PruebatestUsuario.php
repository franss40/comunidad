<?php
/**
 * Pruebas del módulo Usuario
 *
 * @author Fco Sanz
 */
class PruebatestUsuario extends Controller {
    /**
     * Cargamos los modelos
     */
    public function __construct() {
        $this->setModel('Usuarios');
        $this->index();
    }
    
    /**
     * Aquí hacemos los test de todos los casos de uso (CU); uno por uno
     */
    private function index() {
        $this->testListUsuario(); // CU Consultar Usuario
        $usuarioAdd = $this->testAddUsuario();  // CU Alta Usuario
        $usuarioEdit = $this->testEditUsuario($usuarioAdd); // CU Editar Usuario
        $this->testDeleteUsuario($usuarioEdit); // CU Borrar Usuario
    }
    
    /**
     * Probamos el listado de usuarios y
     * El número total de usuarios
     */
    private function testListUsuario() {
        $usuarios = $this->model->getUsuarios();
        $total = $this->model->getTotal();
        
        $esperado = new stdClass();
        $esperado->email_usuario = 'admin@comuni.com';
        $esperado->usuario = 'admin';
        $esperado->password = '$2y$10$qWiYbtigYF6FtXWJPC.nDuNUFEWBBR8Ypej4CngFUYY.FBvqjiZK6';
        $esperado->activo = true;
        $esperado->tipo = 'ADMIN';
        
        assertArrayEquals($esperado, $usuarios, 'Test - Consultar Usuario');
        assertEquals(1, $total, 'Test número de usuarios - Consultar Usuario');
    }
    
    /**
     * Añadimos un registro y comprobamos que se ha añadido
     */
    private function testAddUsuario() : string {
        
        // Al añadir no hay presidente ni vicepresidente
        $esperado = new stdClass();        
        $esperado->email_usuario = 'paco@comuni.com';
        $esperado->usuario = 'paco';
        $esperado->password = 'paco';
        $esperado->activo = false;
        $esperado->tipo = 'OPERARIO';

        // añadimos. Se graba codificado el password.
        $this->model->addUsuario($esperado);
        // recupero de la propia base de datos el password, ya que no es bidireccional para recuperarlo
        $usuario = $this->model->getUsuarios();
        $esperado->password = $usuario[1]->password;
        
        if (!password_verify('paco', $esperado->password)) {
            echo 'No se ha pasado correctamente el Alta de Usuario por el Pass';
            return $esperado->usuario;
        }
        assertArrayEquals($esperado, $usuario, 'Test - Alta Usuario');
        return $esperado->usuario;
    }
    
    
    /**
     * Editamos un registro, para luego comprobar que se han grabado correctamente
     */
    private function testEditUsuario($usuario):string {
        //El usuario no se puede cambiar
        $esperado = new stdClass();        
        $esperado->email_usuario = 'paco2@comuni.com';
        $esperado->usuario = 'paco';
        $esperado->password = 'paco2';
        $esperado->activo = true;
        $esperado->tipo = 'USUARIO';
        
        // editamos
        $this->model->editUsuario($esperado);
        
        // comprobamos
        $user = $this->model->getUsuario($usuario);
        $esperado->password = $user->password;
        if (!password_verify('paco2', $esperado->password)) {
            echo 'No se ha pasado correctamente el Editar Usuario por el Pass';
            return $esperado->usuario;
        }
        
        assertEquals($esperado, $user, 'Test - Editar Usuario');
        return $esperado->usuario;
    }
    
    /*
     * Borramos el usuario
     */
    private function testDeleteUsuario($usuario) {
        // Borramos
        $this->model->borrarUsuario($usuario);
        // Comprobamos que está borrada la comunidad
        assertEquals(0, $this->model->getUsuario($usuario), 'Test - Borrar Comunidad');
    }
}
